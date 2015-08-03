<?php

$page  = $pages->find('/words');
$items = ($page) ? $page->children()->flip() : false;

?>
<?php if($items && $items->count()): ?>
		<?php foreach($items AS $item): ?>
			<div class="subpage">
				<h3><a <?= ($item->isOpen()) ? ' class="active"' : '' ?> href="<?= $item->url() ?>"><?= html($item->title()) ?></a></h3>
				<div class="date">
					<span class="date-day"><?= $item->date('d') ?></span>
					<span class="date-month"><?= $item->date('M') ?></span>
					<span class="date-year"><?= $item->date('Y') ?></span>
				</div>
				<div class="summary"><?= $item->summary() ?></div>
			</div>
		<?php endforeach ?>
<?php endif ?>
