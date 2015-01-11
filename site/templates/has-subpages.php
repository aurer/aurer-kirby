<?= snippet('header') ?>

        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
					
					<nav class="post-list">
					  	<?php foreach($page->children()->sortBy('date', 'desc') AS $p): ?>
                            <div class="post">
                                <h2><a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a></h2>
                                <span class="date"><?= $p->date('jS M Y') ?></span>
                                <div class="summary"><?= $p->summary() ?></div>
                            </div>
						<?php endforeach ?>
					</nav>
                    
                </div>
            </div>
        </section>

<?= snippet('footer') ?>