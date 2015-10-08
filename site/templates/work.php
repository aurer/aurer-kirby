<?= snippet('header') ?>

	<div class="section section--workHero">
		<div class="section-inner">
			<div class="grid grid--padHorizontal">
				<div class="col-lg-2of5 col--primary">
					<h1><?= html($page->title()) ?></h1>

					<h4>Description</h4>
					<?= kirbytext($page->description()) ?>

					<?php if ($features = kirbytext($page->features())) : ?>
						<h4>Features</h4>
						<?= $features ?>
					<?php endif ?>

					<?php if ($technologies = kirbytext($page->technologies())) : ?>
						<h4>Technologies</h4>
						<?= $technologies ?>
					<?php endif ?>
				</div>
				<div class="col-lg-3of5 col--secondary">
					<?= kirbytext($page->hero()) ?>
					<?php if ($links = $page->links()): ?>
						<h4>Visit the site</h4>
						<?= kirbytext($links) ?>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	<div class="section section--workBody">
		<div class="section-inner">
			<?= kirbytext($page->gallery()) ?>
		</div>
	</div>
	<div class="section section--workNav">
		<div class="section-inner">
			<div class="grid grid--padHorizontal grid--alignCenter">
				<?php if ($prev = $page->prev()): ?>
					<div class="col-sm-1of2">
						<div class="workNav workNav--prev">
							<?= thumb($prev->image('cover.jpg'), array('width' => 300))	?>
							<a class="workNav-title" href="<?= $prev->url() ?>"><?= $prev->title() ?></a>
						</div>
					</div>
				<?php endif ?>

				<?php if ($next = $page->next()): ?>
					<div class="col-sm-1of2">
						<div class="workNav workNav--next">
							<?= thumb($next->image('cover.jpg'), array('width' => 300))	?>
							<a class="workNav-title" href="<?= $next->url() ?>"><?= $next->title() ?></a>
						</div>
					</div>
				<?php endif ?>
			</div>
			<?= snippet('appreciate') ?>
		</div>
	</div>

<?= snippet('footer') ?>
