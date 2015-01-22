<?php 

$page  = $pages->find('/projects');
$items = ($page) ? $page->children()->visible()->flip() : false; 

?>
<?php if($items && $items->count()): ?>

<nav class="projects">
    <?php foreach($items AS $item): ?>
    	<div class="project">
            <a href="<?= $item->url() ?>">
                <?php $thumb = $item->files()->find('icon.svg'); ?>
                <div class="project-icon">
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
    <?php endforeach ?>
</nav>
<?php endif ?>
