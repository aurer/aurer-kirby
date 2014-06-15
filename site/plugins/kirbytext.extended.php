<?php 

class kirbytextExtended extends kirbytext {
  
  function __construct($text, $markdown=true) {
    
    parent::__construct($text, $markdown);
    $this->addTags('image');
    $this->addAttributes('caption');
                
  }  

  function image($params) {
    
    //return print_r($this->get(), true);
    $url     = @$params['image'];
    $alt     = @$params['alt'];
    $title   = @$params['title'];
    $caption = @$params['caption'];

    // alt is just an alternative for text
    if(!empty($params['text'])) $alt = $params['text'];
    
    // get metadata (url + file) for the image url
    $imageMeta = $this->url($url, $lang = false, $metadata = true);

    // try to get the title from the image object and use it as alt text
    if($imageMeta['file']) {
      
      if(empty($alt) && $imageMeta['file']->alt() != '') {
        $alt = $imageMeta['file']->alt();
      }

      if(empty($title) && $imageMeta['file']->title() != '') {
        $title = $imageMeta['file']->title();
      }

      // last resort for no alt text
      if(empty($alt)) $alt = $title;

    }

    $imageAttributes = $this->attr(array(
      'src'    => $imageMeta['url'],
      'width'  => @$params['width'], 
      'height' => @$params['height'], 
      'class'  => @$params['class'], 
      'title'  => html($title), 
      'alt'    => html($alt)
    ));
            
    $image = '<img ' . $imageAttributes . ' />';

    if(!empty($params['link'])) {

      // build the href for the link
      $href = ($params['link'] == 'self') ? $url : $params['link'];

      $linkAttributes = $this->attr(array(
        'href'   => $this->url($href),
        'rel'    => @$params['rel'], 
        'class'  => @$params['class'], 
        'title'  => html(@$params['title']), 
      ));
      
      $image = '<a ' . $linkAttributes . self::target($params) . '>' . $image . '</a>';
      
    }

    if(!empty($params['caption'])){
      $caption = '<figcaption>' . $caption . '</figcaption>';
      $image = '<figure>' . $image . $caption . '</figure>';
    }

    return $image;
  }
  
}