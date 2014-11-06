<?php 

$page  = $pages->find('/projects');
$items = ($page) ? $page->children()->visible()->flip() : false; 

?>
<?php if($items && $items->count()): ?>
<nav class="projects">
    <?php foreach($items AS $item): ?>
    	<div class="project">
    		<a href="<?= $item->url() ?>">
    			<h2><?= html($item->title()) ?></h2>
    			<p class="summary"><?= $item->summary() ?></p>
    		</a>
            <?php $thumb = $item->files()->find('thumb.jpg'); ?>
            <?php if( $thumb ): ?>
                <img width="400" height="300" src="<?= $thumb->url() ?>" alt="Thumbnail for <?= html($item->title()) ?>" />
            <?php else: ?>
                <img width="400" height="300" src="http://placehold.it/440x300/333/f54121&text=<?= urlencode($item->title()) ?>" alt="<?= $item->title() ?>">
            <?php endif ?>
    	</div>
    <?php endforeach ?>
</nav>
<?php endif ?>
