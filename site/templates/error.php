<?php 

// Add any additional rediect here
$redirects = array(
	'/^project\/(.*)/' => '/projects/$1'
);

// If a redirect is found - do it
$path = $site->uri()->path();
foreach ($redirects as $src => $dest) {
	if ( preg_match($src, $path) ) {
		header('Location: ' . preg_replace($src, $dest, $path));
		break;
	}
}

$http = new httpResponse;
$statuscode = (String)$http->statuscode();
$statustext = $http->statustext();
?>
<?= snippet('header') ?>

    <section class="main">
  		<div class="row">
            <div class="content">
                <h1><?= "$statuscode $statustext" ?></h1>
                <?= kirbytext($page->$statuscode()) ?>                
            </div>
        </div>
    </section>
        
<?= snippet('footer') ?>