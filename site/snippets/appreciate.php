<?php
	$a = new Appreciation(site());
	$entries = $a->get_user_entries($page->id());
?>
<div class="appreciate">
	<?php if ($entries && count($entries) > 0) : ?>
		<span class="btn btn--appreciated icon-checkmark">Appreciated</span>
	<?php else : ?>
  		<button class="btn btn--appreciate icon-heart" data-page_id="<?= $page->id() ?>"><span>Appreciate</span></button>
  	<?php endif ?>
</div>