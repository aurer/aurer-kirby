<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>
			<?= snippet('projects') ?>
		</div>
	</div>

	<div class="section section--codepen">
		<div class="section-inner">
			<h2 class="section-title">Codepen</h2>
			<div class="pens"></div>
		</div>
	</div>

<?= snippet('footer') ?>
