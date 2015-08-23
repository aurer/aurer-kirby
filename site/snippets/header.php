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

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/assets/gfx/apple-touch-icon.png" />

<?= css(asset_path('assets/css', 'screen.css')) ?>

<!--[if lt IE 9]>
	<?= css(asset_path('assets/css', 'ie.css')) ?>
	<?= js(asset_path('assets/js', 'html5shiv.min.js')) ?>
<![endif]-->
</head>
<body class="<?= snippet('body-class') ?>">
  <?= snippet('mast') ?>
