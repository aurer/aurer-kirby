<?php

	// If a redirect is found - do it
	$path = kirby()->path();
	foreach (c::get('redirects') as $src => $dest) {
		if ( preg_match($src, $path) ) {
			$newurl = preg_replace($src, $dest, $path);
			// Check the page exists in the site and redirect
			if ( $pages->find($newurl)->uri() == substr($newurl, 1) ){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: $newurl");
			}
			break;
		}
	}

	$http = new httpResponse;
	$statuscode = (String)$http->statuscode();
	$statustext = $http->statustext();

?>
<?= snippet('header') ?>

	<div class="section section--main">
		<div class="section-inner">
				<h1><?= "$statuscode $statustext" ?></h1>
				<?= kirbytext($page->$statuscode()) ?>

				<?php if ($statuscode == 404) : ?>

					<form class="form form--search" action="<?= thisURL() ?>#results">
						<div class="grid">
							<div class="col-md-4of5">
								<div class="form-input">
									<input type="text" placeholder="Search…" name="q" value="<?= htmlentities(str_replace('/', ' ', $path)) ?>" autofocus />
								</div>
							</div>
							<div class="col-md-1of5">
								<input class="btn" type="submit" value="Search" />
							</div>
						</div>
					</form>

				<?php endif ?>

		</div>
	</div>

<?= snippet('footer') ?>
