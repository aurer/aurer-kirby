<?php 

kirbytext::$tags['message'] = array(
	'attr' => array(
		'message', 'type',
	),

	'html' => function($tag) {
		$message = $tag->attr('message');
		$type = $tag->attr('type', 'plain');
		$html =  '<ul class="messages"><li class="messages-message messages-message--%s">%s</li></ul>';
		return sprintf($html, $type, $message);
	}
);