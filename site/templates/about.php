<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<div class="content">
				<h1><?= html($page->title()) ?></h1>
				<?= kirbytext($page->text()) ?>
			</div>
		</div>
	</div>

	<div class="section section--experience">
		<div class="section-inner">
			<?= kirbytext($page->text_experience()) ?>
		</div>
	</div>

<?= snippet('footer') ?>
