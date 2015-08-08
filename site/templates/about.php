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
			<h2 class="section-title">Experience</h2>
			<div class="grid grid--padHorizontal">
				<div class="col-lg-1of3">
					<h4>Languages</h4>
					<?= kirbytext($page->languages()) ?>
				</div>
				<div class="col-lg-1of3">
					<h4>Frameworks etc.</h4>
					<?= kirbytext($page->frameworks()) ?>
				</div>
				<div class="col-lg-1of3">
					<h4>Applications</h4>
					<?= kirbytext($page->applications()) ?>
				</div>
			</div>
		</div>
	</div>

<?= snippet('footer') ?>
