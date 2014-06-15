<nav class="nav1">
  	<?php foreach($pages->visible() AS $p): ?>
    	<a <?= ($p->isOpen()) ? ' class="active"' : '' ?> href="<?= $p->url() ?>"><?= html($p->title()) ?></a>
	<?php endforeach ?>
</nav>