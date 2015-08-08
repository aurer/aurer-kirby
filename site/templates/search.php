<?= snippet('header') ?>
	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>

			<!-- Form -->
			<form class="form form--search" action="<?= thisURL() ?>">
				<div class="grid">
					<div class="col-4of5">
						<div class="form-input">
							<input type="text" placeholder="Search…" name="q" value="<?= $query ?>" autofocus />
						</div>
					</div>
					<div class="col-1of5">
						<input class="btn" type="submit" value="Search" />
					</div>
				</div>
			</form>

			<!-- Results -->
			<?php if(	$query) : ?>
				<div class="searchResults">
					<h3><?= $results->count() ?> items found.</h3>
					<?php $results = $results->paginate(10) ?>
					<ul class="searchResults-list">
						<?php foreach($results as $result): ?>
							<li class="searchResult">
								<a class="searchResult-title" href="<?php echo $result->url() ?>">
									<span class="searchResult-title"><?php echo $result->title() ?></span>
									<small class="searchResult-url"><?php echo $result->url() ?></small>
								</a>
							</li>
						<?php endforeach ?>
					</ul>
					<?= pagination($results) ?>
				</div>
			<?php endif ?>
		</div>
	</div>

<?= snippet('footer') ?>
