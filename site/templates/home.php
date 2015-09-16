<?= snippet('header') ?>

	<div class="section section--intro">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<?= snippet('content-types/posts', ['title' => 'A few words']) ?>
	<?= snippet('content-types/social', ['title' => 'Profiles']) ?>

<?= snippet('footer') ?>
