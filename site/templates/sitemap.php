<?php

$ignore = array('sitemap', 'error');

?>
    
<?= snippet('header') ?>
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
<?= snippet('footer') ?>