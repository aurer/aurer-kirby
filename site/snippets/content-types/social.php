<?php
	$profiles = array(
		'github' => 'http://github.com/aurer',
		'twitter' => 'hhttp://twitter.com/_aurer',
		'codepen' => 'http://codepen.io/aurer',
		'instagram' => 'http://instagram.com/_aurer',
	);
?>
<div class="section section--social">
	<div class="section-inner">
		<?php if (isset($title)) : ?><h2 class="section-title"><?= $title ?></h2><?php endif ?>
		<div class="grid grid--padHorizontal">
			<?php foreach ($profiles as $profile => $url) : ?>
				<div class="col-sm-1of2 col-lg-1of4">
					<div class="socialLink socialLink--<?= $profile ?>">
						<a href="<?= $url ?>" target="_blank" title="View my <?= $profile ?> profile">
							<span class="icon icon--<?= $profile ?>">
								<svg width="56" height="56" class="shape-<?= $profile ?>" fill="#ffffff">
								  <use xlink:href="/assets/images/icon-defs.svg#<?= $profile ?>"></use>
								</svg>
							</span>
							<div class="socialLink-handle"><?= ucfirst($profile) ?></div>
						</a>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
