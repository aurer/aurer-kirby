<?= snippet('header') ?>

	<div class="section section--intro">
		<div class="section-inner">
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<div class="section section--workHome">
		<div class="section-inner">
			<h2 class="section-title">Work</h2>
			<div class="grid grid--pad">
				<?php foreach(page('work')->children()->limit(2) as $item) : ?>
					<div class="col-lg-1of2">
						<div class="workPreview">
							<a href="<?php echo $item->url() ?>">
								<?php echo thumb($item->image('cover.jpg'), array('width' => 500)) ?>
								<h3 class="workPreview-title"><?php echo $item->title() ?></h3>
							</a>
						</div>
					</div>
				<?php endforeach ?>
			</div>
			<p class="cta cta--work"><a href="/work">See more</a></p>
		</div>
	</div>
	<?= snippet('content-types/social') ?>

<?= snippet('footer') ?>
