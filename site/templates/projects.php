<?= snippet('header') ?>

        <section class="main">
            <div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
                    <?= snippet('projects') ?>
                </div>
            </div>
        </section>

<?= snippet('footer') ?>