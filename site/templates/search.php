<?= snippet('header') ?>
	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>

			<!-- Form -->
			<form class="form form--search" action="<?= thisURL() ?>#results">
				<div class="grid">
					<div class="col-md-4of5">
						<div class="form-input">
							<input type="text" placeholder="Search…" name="q" value="<?= htmlentities($query) ?>" autofocus />
						</div>
					</div>
					<div class="col-md-1of5">
						<input class="btn" type="submit" value="Search" />
					</div>
				</div>
			</form>

			<!-- Results -->
			<?php if(	$query) : ?>
				<?php $results = $results->paginate(10) ?>
				<div class="searchResults" id="results">
					<?php if ($results->pagination()->items()): ?>
						<h3><?= $results->pagination()->numStart() ?> - <?= $results->pagination()->numEnd() ?> of <?= $results->pagination()->items() ?> results.</h3>
						<ul class="searchResults-list">
							<?php foreach($results as $result): ?>
								<li class="searchResult">
									<a class="searchResult-title" href="<?= $result->url() ?>">
										<span class="searchResult-title"><?= $result->title() ?></span>
										<small class="searchResult-url"><?= $result->url() ?></small>
									</a>
								</li>
							<?php endforeach ?>
						</ul>
						<?= pagination($results) ?>
					<?php else: ?>
						<p class="searchResults-noResults">Your search for <strong>"<?= htmlentities($query) ?>"</strong> returned no results.</p>
					<?php endif ?>
				</div>
			<?php endif ?>
		</div>
	</div>

<?= snippet('footer') ?>
