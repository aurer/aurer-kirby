<?= snippet('header') ?>

        <section class="main">
            <div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                </div>
            </div>
        </section>

        <section class="main experience">
        	<div class="row">
        		<?= kirbytext($page->text_experience()) ?>
        	</div>
        </section>

        <section class="main site">
        	<div class="row">
        		<?= kirbytext($page->text_site()) ?>
        	</div>
        </section>

<?= snippet('footer') ?>