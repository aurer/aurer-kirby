<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
		</div>
	</div>
	<div class="section section--primary">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<?= snippet('content-types/social') ?>

	<?= snippet('content-types/experience') ?>

<?= snippet('footer') ?>
