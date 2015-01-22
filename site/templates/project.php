<?= snippet('header') ?>

        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                </div>
                <?= snippet('appreciate') ?>
            </div>
        </section>

<?= snippet('footer') ?>