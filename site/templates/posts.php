<?= snippet('header') ?>

	<div class="section section--posts">
		<div class="section-inner">
				<h1><?= html($page->title()) ?></h1>
				<?= kirbytext($page->text()) ?>

				<nav class="posts">
					<?php foreach($page->children()->sortBy('date', 'desc') AS $p): ?>
						<div class="post">
							<h2 class="post-title"><a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a></h2>
							<div class="post-summary"><?= $p->summary() ?></div>
							<div class="post-date">
								<span class="date-day"><?= $p->date('d') ?></span>
								<span class="date-month"><?= $p->date('M') ?></span>
								<span class="date-year"><?= $p->date('Y') ?></span>
							</div>
						</div>
					<?php endforeach ?>
				</nav>
		</div>
	</div>

<?= snippet('footer') ?>
