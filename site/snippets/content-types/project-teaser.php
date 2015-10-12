<div class="section section--projectTeaser">
	<div class="section-inner">
		<?php if (isset($title)) : ?><h2 class="section-title"><?= $title ?></h2><?php endif ?>
		<div class="grid grid--pad">
			<?php foreach(page('/projects')->children()->visible()->flip()->limit(3) AS $item): ?>
				<div class="col-md-1of2 col-xl-1of3">
					<div class="project">
						<a href="<?= $item->url() ?>">
							<div class="project-icon">
								<?php $thumb = $item->files()->find('icon.svg'); ?>
								<?php if( $thumb ): ?>
									<?php include $thumb->root() ?>
								<?php endif ?>
							</div>
							<div class="project-details">
								<h2 class="project-title"><?= html($item->title()) ?></h2>
								<p class="project-summary"><?= $item->summary() ?></p>
							</div>
						</a>
					</div>
				</div>
			<?php endforeach ?>
		</div>
		<p class="cta cta--more"><a href="/projects">See more</a></p>
	</div>
</div>
