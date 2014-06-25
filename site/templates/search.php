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
                    
                    <?php
                    $search = new search(array(
                        'searchfield' => 'q'
                    ));
                    $results = $search->results();
                    ?>

                    <form class="standard search" action="<?= thisURL() ?>">
                        <div class="input">
                            <input type="text" placeholder="Search…" name="q" value="<?= $search->query() ?>" autofocus />
                        </div>
                        <input type="submit" value="Search" />
                    </form>

                    <?php if($results): ?>
                        <h3><?= $results->count() ?> items found matching '<?= html($search->query()) ?>'</h3>
                        <ul class="display-list">
                            <?php foreach($results as $result): ?>
                                <li>
                                    <a class="result-title" href="<?php echo $result->url() ?>">
                                        <span class="result-title"><?php echo $result->title() ?></span>
                                        <small><?php echo $result->url() ?></small>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>

                </div>
            </div>
        </section>

        <?= snippet('foot') ?>
   
    </body>
</html>