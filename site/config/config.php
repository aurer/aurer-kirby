<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'put your license key here');

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/
c::set('kirbytext.video.width', 480); 
c::set('kirbytext.video.height', 358);
/*

---------------------------------------
Routes
---------------------------------------

*/

c::set('routes', array(
	array(
		'method' => 'GET',
		'pattern' => 'appreciate',
		'action' => function() {
			return go(kirby()->request()->referer());
		}
	),
	array(
		'method' => 'POST',
		'pattern' => 'appreciate',
		'action' => function() {
			if (get('page_id') == '') {
				return go(kirby()->request()->referer());
			}
			$a = new Appreciation(site());
			$entry = $a->appreciate(get('page_id'));
			return response::json($entry);
		}
	),
	array(
		'method' => 'POST',
		'pattern' => 'appreciate/comment',
		'action' => function() {
			if( !get('id') ) {
				return go(kirby()->request()->referer());
			}
			$a = new Appreciation(site());
			$data = (object)array(
				'comments' => get('comments'),
				'name' => get('name')
			);
			$entry = $a->add_comment(get('id'), $data);
			return response::json($entry);
		}
	)
));