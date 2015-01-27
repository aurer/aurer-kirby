<!DOCTYPE html>
<html lang="en" <?= c::get('html-attr') ?>>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?= html($site->title()) ?> - <?= html($page->title()) ?></title>
		<meta name="description" content="<?= html($site->description()) ?>">
		<meta name="keywords" content="<?= html($site->keywords()) ?>" />
		<meta name="robots" content="index, follow" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  		<link rel="apple-touch-icon" href="/assets/dist/gfx/apple-touch-icon.png" />
  		<link rel="apple-touch-icon" sizes="57x57" href="/assets/dist/gfx/apple-touch-icon-57.png" />
  		<link rel="apple-touch-icon" sizes="72x72" href="/assets/dist/gfx/apple-touch-icon-72.png" />
  		<link rel="apple-touch-icon" sizes="76x76" href="/assets/dist/gfx/apple-touch-icon-76.png" />
  		<link rel="apple-touch-icon" sizes="114x114" href="/assets/dist/gfx/apple-touch-icon-114.png" />
  		<link rel="apple-touch-icon" sizes="120x120" href="/assets/dist/gfx/apple-touch-icon-120.png" />
  		<link rel="apple-touch-icon" sizes="144x144" href="/assets/dist/gfx/apple-touch-icon-144.png" />
  		<link rel="apple-touch-icon" sizes="152x152" href="/assets/dist/gfx/apple-touch-icon-152.png" />

		<?= css(asset_path('assets/dist/css', 'screen.css')) ?>
		<!--[if lt IE 9]>
			<?= css(asset_path('assets/dist/css', 'ie8.css')) ?>
            <script src="/assets/dist/js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <body class="<?= snippet('body-class') ?>">
        
        <?= snippet('mast') ?>
        <?= snippet('messages') ?>