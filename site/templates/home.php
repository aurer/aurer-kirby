<?= snippet('header') ?>

	<div class="section section--intro">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<?= snippet('content-types/posts', ['title' => 'Some things I wrote']) ?>
	<?= snippet('content-types/social', ['title' => 'Find me on...']) ?>

<?= snippet('footer') ?>
