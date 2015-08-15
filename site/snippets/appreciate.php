<?php
	$a = new Appreciation(site());
	$entries = $a->get_user_entries($page->id());
?>
<div class="section section--appreciate">
	<div class="section-inner">
		<?php if ($entries && count($entries) > 0) : ?>
			<button disabled class="appreciate appreciate--active">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 16 16">
				<path fill="#fff" d="M11.8 1c-1.682 0-3.129 1.368-3.799 2.797-0.671-1.429-2.118-2.797-3.8-2.797-2.318 0-4.2 1.882-4.2 4.2 0 4.716 4.758 5.953 8 10.616 3.065-4.634 8-6.050 8-10.616 0-2.319-1.882-4.2-4.2-4.2z"></path>
				</svg>
			</button>
		<?php else : ?>
	  	<button class="appreciate" data-page_id="<?= $page->id() ?>">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 16 16">
				<path fill="#fff" d="M11.8 1c-1.682 0-3.129 1.368-3.799 2.797-0.671-1.429-2.118-2.797-3.8-2.797-2.318 0-4.2 1.882-4.2 4.2 0 4.716 4.758 5.953 8 10.616 3.065-4.634 8-6.050 8-10.616 0-2.319-1.882-4.2-4.2-4.2z"></path>
				</svg>
	  	</button>
	  <?php endif ?>
	</div>
</div>
