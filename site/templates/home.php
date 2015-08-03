<?= snippet('header') ?>

	<div class="section section--intro">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<div class="section section--projects">
		<div class="section-inner">
			<h2>Projects</h2>
			<div class="projects">
				<?= snippet('projects') ?>
			</div>
		</div>
	</div>

<?= snippet('footer') ?>
