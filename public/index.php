<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(__DIR__ . '/..'));

// load kirby
require(ROOT . DS . 'kirby' . DS . 'bootstrap.php');

// check for a custom site.php
if(file_exists(ROOT . DS . 'site.php')) {
  require(ROOT . DS . 'site.php');
} else {
  $kirby = kirby();
}

// render
echo $kirby->launch();
