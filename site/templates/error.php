<?php 

    // If a redirect is found - do it
    $path = kirby()->path();
    foreach (c::get('redirects') as $src => $dest) {
        if ( preg_match($src, $path) ) {
            $newurl = preg_replace($src, $dest, $path);
            // Check the page exists in the site and redirect
            if ( $pages->find($newurl)->uri() == substr($newurl, 1) ){
                header("HTTP/1.1 301 Moved Permanently"); 
                header("Location: $newurl");
            }
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
                
                <?php if ($statuscode == 404) : ?>
            
                    <form class="standard search" action="/search">
                        <div class="input">
                            <input type="text" placeholder="Search…" name="q" value="<?= str_replace('/', ' ', $path) ?>" autofocus />
                        </div>
                        <input type="submit" value="Search" />
                    </form>

                <?php endif ?>
            
            </div>
        </div>
    </section>
        
<?= snippet('footer') ?>