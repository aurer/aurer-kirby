<?= snippet('header') ?>

        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>
					
					
					<nav class="nav2">
					  	<?php foreach($page->children() AS $p): ?>
					    	<a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a>
						<?php endforeach ?>
					</nav>
                    
                </div>
            </div>
        </section>

<?= snippet('footer') ?>