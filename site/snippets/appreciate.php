<?php
	$a = new Appreciation(site());
	$entries = $a->get_user_entries($page->id());
?>
<div class="section section--appreciate">
	<div class="section-inner">
		<?php if ($entries && count($entries) > 0) : ?>
			<button disabled class="appreciate appreciate--active">
				<svg width="20" height="20" fill="#ffffff">
				  <use xlink:href="/assets/images/icon-defs.svg#heart"></use>
				</svg>
			</button>
		<?php else : ?>
	  	<button class="appreciate" data-page_id="<?= $page->id() ?>">
				<svg width="20" height="20" fill="#ffffff">
				  <use xlink:href="/assets/images/icon-defs.svg#heart"></use>
				</svg>
	  	</button>
	  <?php endif ?>
	</div>
</div>
