<?php c::set('html-attr', 'ng-app="lastFmApp"') ?>
<?= snippet('header') ?>
    	
        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>

                    <div class="music-tracks" ng-controller="lastController">
                        <div class="load-icon"><?= snippet('loading') ?></div>
                        <div class="track-list"><!-- Tracks loaded here --></div>
                    </div>

                </div>
            </div>
        </section>

<?= snippet('footer') ?>