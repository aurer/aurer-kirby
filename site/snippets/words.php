<?php

$page  = $pages->find('/words');
$posts = ($page) ? $page->children()->flip() : false;

?>
<?php if($posts && $posts->count()): ?>
		<?php foreach($posts AS $p): ?>
			<div class="post">
				<h3 class="post-title"><a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a></h3>
				<div class="post-summary"><?= $p->summary() ?></div>
				<div class="post-date">
					<span class="date-day"><?= $p->date('d') ?></span>
					<span class="date-month"><?= $p->date('M') ?></span>
					<span class="date-year"><?= $p->date('Y') ?></span>
				</div>
			</div>
		<?php endforeach ?>
<?php endif ?>