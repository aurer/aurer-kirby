<?php 

$page  = $pages->find('/projects');
$items = ($page) ? $page->children()->visible() : false; 

?>
<?php if($items && $items->count()): ?>
<nav class="projects">
    <?php foreach($items AS $item): ?>
    	<div class="project">
    		<a href="<?= $item->url() ?>">
    			<h2><?= html($item->title()) ?></h2>
    			<div class="detail">
    				<?php $thumb = $item->files()->find('thumb.jpg'); ?>
    				<?php if( $thumb ): ?>
    					<img src="<?= $thumb->url() ?>" alt="Thumbnail for <?= html($item->title()) ?>" />
    				<?php else: ?>
                        <img src="http://placehold.it/220x150/&text=<?= urlencode($item->title()) ?>" alt="<?= $item->title() ?>">
                    <?php endif ?>
    				<div class="summary"><?= $item->summary() ?></div>
    			</div>
    		</a>
    	</div>
    <?php endforeach ?>
</nav>
<?php endif ?>
