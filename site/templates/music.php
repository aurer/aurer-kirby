<?= snippet('header') ?>

        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>

                    <div class="music-tracks">
                        <div class="load-icon">
                            <!-- <img src="/assets/dist/gfx/loading.svg" onerror="this.src='/assets/dist/gfx/loading.png'" alt="Loading icon"> -->
                        </div>
                        <div class="track-list"><!-- Tracks loaded here --></div>
                    </div>

                </div>
            </div>
        </section>

        <script src="/assets/dist/js/music.js"></script>

<?= snippet('footer') ?>