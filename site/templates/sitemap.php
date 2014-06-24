<?php

$ignore = array('sitemap', 'error');

if( $site->uri()->extension == 'xml' ) : 
    header('Content-type: text/xml; charset="utf-8"');
    echo '<?xml version="1.0" encoding="utf-8"?>';
    ?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <?php foreach($pages->index() as $p): ?> 
        <?php if(in_array($p->uri(), $ignore)) continue ?>
            <url>
                <loc><?php echo html($p->url()) ?></loc>
                <lastmod><?php echo $p->modified('c') ?></lastmod>
                <priority><?php echo ($p->isHomePage()) ? 1 : number_format(0.5/$p->depth(), 1) ?></priority>
            </url>
        <?php endforeach ?>  
    </urlset>

<?php else : ?>
    
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <?= snippet('head') ?>
        </head>
        <body class="<?= snippet('body-class') ?>">
            <?= snippet('mast') ?>
            <section class="main">
                <div class="row">
                    <div class="content">
                        <h1><?= html($page->title()) ?></h1>
                        <?= kirbytext($page->text()) ?>
                        <ul class="sitemap">
                            <?php foreach($pages->index() as $p): ?> 
                                <?php if(in_array($p->uri(), $ignore)) continue ?>
                                <li class="depth-<?= $p->depth() ?>">
                                    <a href="<?= $p->url() ?>"><?= $p->title() ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </section>            
            <?= snippet('foot') ?>
        </body>
    </html>

<?php endif ?>