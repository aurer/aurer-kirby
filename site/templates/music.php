<?= snippet('header') ?>

	<div class="section section--main section--music">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>

			<div class="track-list" id="tracklist">Loading...<!-- Tracks loaded here --></div>
			<div class="track-pagination"><!-- Pagination loaded here --></div>

			<?= snippet('appreciate') ?>
		</div>
	</div>
	<?= js(asset_path('assets/js', 'music.js'), 'defered') ?>

<?= snippet('footer') ?>
