<?php
$path = '/words';
if ($page->depth() == 2) {
	$path = '/words/archive';
}
$page  = $pages->find($path);
$posts = ($page) ? $page->children()->flip() : false;

?>
<?php if($posts && $posts->count()): ?>
	<div class="section section--words">
		<div class="section-inner">
			<?php if (isset($title)) : ?><h2 class="section-title"><?= $title ?></h2><?php endif ?>
			<div class="words">
				<?php foreach($posts AS $p): ?>
					<div class="post">
						<h3 class="post-title"><a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a></h3>
						<div class="post-summary"><?= $p->summary() ?></div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
<?php endif ?>
