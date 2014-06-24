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
                    <h1><?php html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                    <?= snippet('projects') ?>
                </div>
            </div>
        </section>

        <?= snippet('foot') ?>
   
    </body>
</html>