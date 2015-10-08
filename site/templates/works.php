<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
			<h1><?= html($page->title()) ?></h1>
			<?= kirbytext($page->text()) ?>
		</div>
	</div>

	<div class="section section--works">
		<div class="section-inner">
			<div class="grid grid--pad">
				<?php foreach($page->children() as $item) : ?>
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
		</div>
	</div>

<?= snippet('footer') ?>
