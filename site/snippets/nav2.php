<?php 

// find the open/active page on the first level
$open  = $pages->findOpen();
$items = ($open) ? $open->children()->visible()->flip() : false; 

?>
<?php if($items && $items->count()): ?>
	<nav class="nav2">
		<?php if($page->parent()): ?>
			
		<?php endif ?>
		<h2>
			<a href="<?= $page->parent()->url() ?>">
				<?= $page->parent()->title() ?>
			</a>
		</h2>
	    <?php foreach($items AS $item): ?>
	    	<a <?= ($item->isOpen()) ? ' class="active"' : '' ?> href="<?= $item->url() ?>"><?= html($item->title()) ?></a>
	    <?php endforeach ?>            
	</nav>
<?php endif ?>
