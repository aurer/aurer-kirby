<?= snippet('header') ?>

	<div class="section section--intro">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<div class="section section--projects">
		<div class="section-inner">
			<h2 class="section-title"><a href="/projects">Projects</a></h2>
			<div class="projects">
				<?= snippet('projects') ?>
			</div>
		</div>
	</div>

	<div class="section section--words">
		<div class="section-inner">
			<h2 class="section-title"><a href="/words">Words</a></h2>
			<div class="words">
				<?= snippet('words') ?>
			</div>
		</div>
	</div>

<?= snippet('footer') ?>
