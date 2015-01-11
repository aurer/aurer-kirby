<?= snippet('header') ?>
        
        <section class="intro">
            <div class="row">
                <?= kirbytext($page->text()) ?>
            </div>
        </section>

        <section class="main">
            <div class="row">
                <h2>Projects</h2>
                <div class="content">
                    <?= snippet('projects') ?>
                </div>
            </div>
        </section>

<?= snippet('footer') ?>