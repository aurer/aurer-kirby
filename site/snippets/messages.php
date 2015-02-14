<?php if ( !empty(s::get('messages')) ) : ?>
	<section class="messages-container">
		<div class="row">
			<?= message::all() ?>
		</div>
	</section>
<?php endif ?>