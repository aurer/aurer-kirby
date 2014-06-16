<!DOCTYPE html>
<html lang="en">
    <head>
        <?= snippet('head') ?>
    </head>
    <body class="default <?= $site->uri()->path() ?>">
        
        <?= snippet('mast') ?>
    	
        <section class="main">
      		<div class="row">
                <?= snippet('nav2') ?>
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                </div>
        	</div>
        </section>
        
        <?= snippet('foot') ?>
    
    </body>
</html>