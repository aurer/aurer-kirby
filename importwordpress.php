<?php

/*
 * Functionality to convert Wordpress a export to something closer to the Kirby structure,
 * in order to help Paul Swain's specific migration needs.
 * Uses HTML to Markdown functionality by Nick Cernis - https://github.com/nickcernis/html-to-markdown
 */

require_once('HTML_To_Markdown.php');

function rmdir_recursive($dir) { 
    $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? rmdir_recursive("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
}

//Define the namespaces used in the XML document
$ns = array (
    'excerpt' => "http://wordpress.org/export/1.2/excerpt/",
    'content' => "http://purl.org/rss/1.0/modules/content/",
    'wfw' => "http://wellformedweb.org/CommentAPI/",
    'dc' => "http://purl.org/dc/elements/1.1/",
    'wp' => "http://wordpress.org/export/1.2/"
);
 
//Get the contents of the import file
$importfile = 'aurer.wordpress.xml';
$exportdir = 'content/archive/'; //Include training slash please
$xml = file_get_contents($importfile);
$xml = new SimpleXmlElement($xml);

rmdir_recursive($exportdir);
mkdir($exportdir);
file_put_contents($exportdir . 'words.txt', "Title: Archive\n----\nText:");

//Grab each item
foreach ($xml->channel->item as $item) {
    $post = (object)[];
    $wp = $item->children($ns['wp']);
    $url = (String)$wp->post_name;

    if (($wp->post_type == 'post' || $wp->post_type == 'project') && $wp->status == 'publish') {
        $postdir = $exportdir . $url;
        $post->title = (String)$item->title;
        $post->date = date('Y/m/d', strtotime($item->pubDate));
        // $post->summary = (String)trim($item->children($ns['excerpt'])->encoded);
        $post->text = (String)trim($item->children($ns['content'])->encoded);

        // Convert to markdown - optional param to strip tags
        $markdown = new HTML_To_Markdown($post->text, array('strip_tags' => false));
        
        // Create text file content
        $post->text = $markdown->output();
        $text_file_content = "";
        foreach ($post as $key => $value) {
            $text_file_content .= ucfirst($key) . ": " . $value . "\n----\n";
        }

        
        // Pull out and download any uploaded images in the post
        $image_pattern = '/http:\/\/aurer\.co\.uk\/wp-content\/uploads\/[\d]+\/[\d]+\/(?<filename>[\w-]+\.(?<type>jpg|jpeg|png|gif))/';
        preg_match_all($image_pattern, $text_file_content, $matches);
        if ( count($matches[0]) > 0 ) {
            $text_file_content = preg_replace('/http:\/\/aurer.co.uk\/wp-content\/uploads\/[\d]+\/[\d]+\//', "/" . $exportdir . $url . "/", $text_file_content);
        }
        
        // Create the posts folder
        mkdir($postdir);
        file_put_contents($postdir . '/post.txt', $text_file_content);
    }
}

function get_post_name_by_id($xml, $id) {
    foreach ($xml->channel->item as $item) {
        $wp = $item->children("http://wordpress.org/export/1.2/");
        if ( (String)$wp->post_id == (String)$id) {
            return (String)$wp->post_name;
        }
    }
    return false;
}

foreach ($xml->channel->item as $item) {
    $wp = $item->children("http://wordpress.org/export/1.2/");
    if ($wp->post_type == 'attachment') {
        $post_name = get_post_name_by_id($xml, $wp->post_parent);
        $post_dir = $exportdir .$post_name;
        preg_match('/(?<filename>[\w-\.]+\.[\w]+)$/', $wp->attachment_url, $filename_matches);
        if ($post_name && is_dir($post_dir)) {
            file_put_contents($post_dir . "/" . $filename_matches['filename'], file_get_contents($wp->attachment_url));
        }
    }
}