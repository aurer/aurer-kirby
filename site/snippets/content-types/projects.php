<?php

$page  = $pages->find('/projects');
$items = ($page) ? $page->children()->visible()->flip() : false;

?>
<?php if($items && $items->count()): ?>
	<div class="section section--projects">
		<div class="section-inner">
			<?php if (isset($title)) : ?><h2 class="section-title"><?= $title ?></h2><?php endif ?>
			<div class="grid grid--pad">
				<?php foreach($items AS $item): ?>
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
		</div>
	</div>
<?php endif ?>
