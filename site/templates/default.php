<!DOCTYPE html>
<html lang="en">
    <head>
        <?= snippet('head') ?>
    </head>
    <body class="<?= $page->template() ?>">
        
        <?= snippet('mast') ?>
    	
        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                </div>
            </div>
        </section>
        
        <?= snippet('nav2') ?>
        <?= snippet('foot') ?>
    
    </body>
</html>