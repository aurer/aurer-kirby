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
            <?php $thumb = $item->files()->find('icon.svg'); ?>
            <div class="icon">
                <?php if( $thumb ): ?>
                    <?php include $thumb->root() ?>
                <?php endif ?>
                <h3><?php echo $item->title() ?></h3>
            </div>
    	</div>
    <?php endforeach ?>
</nav>
<?php endif ?>
