<?= snippet('header') ?>

	<div class="section section--intro">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<?= snippet('content-types/work-teaser', ['title' => 'Work']) ?>
	<?= snippet('content-types/project-teaser', ['title' => 'Projects']) ?>
	<?= snippet('content-types/social') ?>

<?= snippet('footer') ?>
