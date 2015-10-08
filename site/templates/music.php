<?= snippet('header') ?>

	<div class="section section--main section--music">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>

			<div id="tracklist">Loading...<!-- Tracks loaded here --></div>
			<div id="tracklist-pagination"><!-- Pagination loaded here --></div>

			<?= snippet('appreciate') ?>
		</div>
	</div>

	<?= js(asset_path('assets/js', 'music.js'), 'defered') ?>

	<script type="text/template" id="track-template">
		<div class="track">
		    <a class="track-cover" href="<%= url %>" title="View this track on Last.FM" target="_blank">
		      <img src="/assets/images/blank.svg" width="300" height="300" class="track-image-placeholder" />
		      <img src="<%= thumbnail.url %>" width="300" height="300" class="track-image" />
		    </a>
		    <div class="track-details">
			    <a class="track-info" href="<%= url %>" title="View this track on Last.FM" target="_blank">
			        <b class="track-name"><%= name %></b>
			        <span class="track-artist"><%= artist %></span>
			        <small class="track-status"><%= timestamp %></small>
			    </a>
		    </div>
		</div>
	</script>

	<script type="text/template" id="pagination-template">
		<div class="pagination">
			<a <%= prevPage > 0 ? 'href="#'+prevPage+'"' : '' %> class="pagination-prev">Newer</a>
			<% _.each(pages, function(page, i) { %>
				<a class="pagination-page <%= page.stateClass %>" href="#<%= page.number %>"><%= page.number %></a>
			<% }); %>
			<a <%= nextPage <= totalPages ? 'href="#'+nextPage+'"' : '' %>  class="pagination-next">Older</a>
		</div	>
	</script>


<?= snippet('footer') ?>
