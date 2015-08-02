<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<div class="content">
				<h1><?= html($page->title()) ?></h1>
				<?= kirbytext($page->text()) ?>
				<?= snippet('projects') ?>
			</div>
		</div>
	</div>

	<div class="section section--codepen">
		<div class="section-inner">
			<div class="content">
				<h1>Codepen</h1>
				<div class="pens"></div>
			</div>
		</div>
	</div>

<?= snippet('footer') ?>
