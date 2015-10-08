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

<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicons/favicon-194x194.png" sizes="194x194">

<?= css(asset_path('assets/css', 'screen.css'), 'all') ?>
<?= css(asset_path('assets/css', 'print.css'), 'print') ?>

<!--[if lt IE 9]>
	<?= css(asset_path('assets/css', 'ie.css')) ?>
	<?= js(asset_path('assets/js', 'html5shiv.min.js')) ?>
<![endif]-->
</head>
<body class="<?= snippet('body-class') ?>">
  <?= snippet('mast') ?>
