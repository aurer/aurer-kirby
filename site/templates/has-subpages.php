<?= snippet('header') ?>

        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
					
					<nav class="subpages">
					  	<?php foreach($page->children()->sortBy('date', 'desc') AS $p): ?>
                            <div class="subpage">
                                <h2><a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a></h2>
                                <div class="date">
                                    <span class="date-day"><?= $p->date('d') ?></span>
                                    <span class="date-month"><?= $p->date('M') ?></span>
                                    <span class="date-year"><?= $p->date('Y') ?></span>
                                </div>
                                <div class="summary"><?= $p->summary() ?></div>
                            </div>
						<?php endforeach ?>
					</nav>
                    
                </div>
            </div>
        </section>

<?= snippet('footer') ?>