<?php

$posts = ($path) ? $pages->find($path)->children()->sortBy('date', 'desc') : $page->children()->flip();

?>
<?php if($posts && $posts->count()): ?>
	<nav class="posts">
		<?php foreach($posts AS $p): ?>
			<div class="post">
				<h2 class="post-title"><a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a></h2>
				<div class="post-summary"><?= $p->summary() ?></div>
				<div class="post-date">
					<span class="date-day"><?= $p->date('d') ?></span>
					<span class="date-month"><?= $p->date('M') ?></span>
					<span class="date-year"><?= $p->date('Y') ?></span>
				</div>
			</div>
		<?php endforeach ?>
	</nav>
<?php endif ?>
