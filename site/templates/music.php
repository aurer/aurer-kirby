<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>
			<div class="music-tracks">
				<div class="load-icon"></div>
				<div class="track-list"><!-- Tracks loaded here --></div>
			</div>
			<?= snippet('appreciate') ?>
		</div>
	</div>

	<script src="/assets/dist/js/music.js"></script>

<?= snippet('footer') ?>
