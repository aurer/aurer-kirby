<div class="section section--workTeaser">
	<div class="section-inner">
		<?php if (isset($title)) : ?><h2 class="section-title"><?= $title ?></h2><?php endif ?>
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
		<p class="cta cta--more"><a href="/work">See more</a></p>
	</div>
</div>
