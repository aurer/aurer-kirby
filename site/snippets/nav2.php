<?php 

// find the open/active page on the first level
$open  = $pages->findOpen();
$items = ($open) ? $open->children()->visible()->flip() : false; 

?>
<?php if($items && $items->count()): ?>
	<section class="nav2">
		<div class="row">
			<h2>
				<a href="<?= $page->parent()->url() ?>">
					<?= $page->parent()->title() ?>
				</a>
			</h2>
			<nav>
			    <?php foreach($items AS $item): ?>
			    	<a <?= ($item->isOpen()) ? ' class="active"' : '' ?> href="<?= $item->url() ?>"><?= html($item->title()) ?></a>
			    <?php endforeach ?>            
			</nav>
		</div>
	</section>
<?php endif ?>
