<?php

// Routes
c::set('routes', array (
	// Test
	array (
		'method' => 'GET',
		'pattern' => 'test',
		'action' => function() {
			Appreciation::get_lat_long('190.234.12.116');
		}
	),

	// Sitemap
	array (
		'method' => 'GET',
		'pattern' => 'sitemap.xml',
		'action' => function(){
			$ignore = array ('sitemap', 'error');
			header('Content-type: text/xml; charset="utf-8"');
			echo '<?xml version="1.0" encoding="utf-8"?>';
		    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		    foreach (kirby()->site->pages()->index() as $p) {
		    	if(in_array ($p->uri(), $ignore)) continue;
		    	echo "<url>";
		    	echo "<loc>" . html($p->url()) . "</loc>";
		    	echo "<lastmod>" . $p->modified('c') . "</lastmod>";
		    	echo "<priority>" . (($p->isHomePage()) ? 1 : number_format(0.5/$p->depth(), 1)) . "</priority>";
		    	echo "</url>";
		    }
		    echo '</urlset>';
		}
	),

	// Block GET request to /appreciate
	array (
		'method' => 'GET',
		'pattern' => 'appreciate',
		'action' => function() {
			return go(kirby()->request()->referer());
		}
	),

	// Create an appreciation
	array (
		'method' => 'POST',
		'pattern' => 'appreciate',
		'action' => function() {
			// Return if no ID was sent
			if (get('page_id') == '') {
				return go(kirby()->request()->referer());
			}

			// Create the appreciation
			$a = new Appreciation(site());
			$entry = $a->appreciate(get('page_id'));

			// Send an email
			$email = new Email(array(
				'to'      => c::get('site_email'),
				'from'    => 'Aurer emailer <noreply@aurer.co.uk>',
				'subject' => 'Someone appreciates your work',
				'body'    => 'Page: ' . $entry['page'] . "\nTime: " . date('D, jS M, Y, G:i', $entry['timestamp']) . "\nIP: " . $entry['ip'],
				'service' => 'mailgun',
				'options' => array(
					'key'    => c::get('mailgun_key'),
					'domain' => c::get('mailgun_domain'),
				)
			));

			// Log email failures
			if(!$email->send()) {
				error_log($email->error());
			}

			// Return JSON result
			return response::json($entry);
		}
	),

	// Create a comment
	array (
		'method' => 'POST',
		'pattern' => 'appreciate/comment',
		'action' => function() {
			if( !get('id') ) {
				return go(kirby()->request()->referer());
			}
			$a = new Appreciation(site());
			$data = (object)array (
				'comments' => get('comments'),
				'name' => get('name')
			);
			$entry = $a->add_comment(get('id'), $data);
			return response::json($entry);
		}
	),

	// Return pens from codepen
	array (
		'method' => 'GET',
		'pattern' => 'pens',
		'action' => function() {
			$rss = file_get_contents('http://codepen.io/aurer/public/feed');
			$xml = new SimpleXMLElement($rss);

			$pens = array();
			foreach ($xml->channel->item as $item) {
				$pen = new StdClass;
				$pen->title = (String)$item->title;
				$pen->link = (String)$item->link;
				$pens[] = $pen;
			}
			return response::json($pens);
		}
	),
));
