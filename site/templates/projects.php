<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<?= snippet('content-types/projects') ?>

<?= snippet('footer') ?>
