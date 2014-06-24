<?php
	
	$classes = array();

	$template = $page->template();
	$title = preg_replace('/[^a-z\d-]/', '-', strtolower(trim($page->title())));

	array_push($classes, 'template-' . $template);
	array_push($classes, 'page-' . $title);

	echo implode(' ', $classes);
?>