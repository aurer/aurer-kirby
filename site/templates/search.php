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
                                    <a class="result-title" href="<?php echo $result->url() ?>"><?php echo $result->title() ?></a>
                                    <small><a href="<?php echo $result->url() ?>"><?php echo $result->url() ?></a></small>
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