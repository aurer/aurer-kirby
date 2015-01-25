<?php 

class Appreciation {

	// The filename to store the data in
	public $appreciation_filename = 'appreciation.json';
	public $cookie_name = 'ilikeit';

	//
	// Initialise the Appreciation object passing the Kirby site object
	//
	public function __construct($site) {
		$this->site = $site;
		$this->root = $site->kirby->roots->index;
	}

	//
	//	Add a single appreciation entry
	//
	public function appreciate($url) {
		$data = array(
			'id' => $this->get_cookie() ? $this->get_cookie() : uniqid(),
			'page' => $url,
			'timestamp' => time(),
			'ip' => R::ip()
		);
		return $this->add_entry($data);
	}

	//
	// Return array of all entries based on users cookie
	//
	public function get_user_entries($page=false) {
		$id = $this->get_cookie();
		
		if( !$id ) {
			return false;
		}

		$user_entries = array();
		$all_entries = $this->get_all_appreciations()->entries;
		foreach ($all_entries as $entry) {
			if ($entry->id == $id) {
				if ($page) {
					if ($entry->page == $page) {
						$user_entries[] = $entry;
					}
				} else {
					$user_entries[] = $entry;
				}
			}
		}
		return $user_entries;
	}

	//
	// Add a single appreciation entry
	//
	private function add_entry($data) {
		$appreciation_file = $this->appreciations_filepath();

		if (!is_file($appreciation_file)) {
			$this->create_appreciation_file();
		}
		
		$appreciations = $this->get_all_appreciations();
		$appreciations->entries[] = $data;
		$this->save_appreciations($appreciations);

		$this->set_cookie($data['id']);

		return $data;
	}

	//
	// Update an entry
	//
	private function update_appreciation($data, $id) {
		$appreciation_file = $this->appreciations_filepath();

		if (!is_file($appreciation_file)) {
			$this->create_appreciation_file();
		}

		// Get all appreciations
		$appreciations = $this->get_all_appreciations()->entries;
		
		// Find the one we want to update
		$appreciation = false;
		foreach ($appreciations as $entry) {
			if ($entry->id == $id) {
				$appreciation = $entry;
			}
		}

		// If we didn't find it return
		if (!$appreciation) {
			return false;
		}

		// Otherwise update the entry
		foreach ($data as $key => $value) {
			$appreciation->$key = $value;
		}

		// Save the json
		$this->save_appreciations($appreciations);
		
		// Return the updated entry
		return $appreciation;
	}

	//
	// Save all appreciations back into the JSON file
	//
	private function save_appreciations($data) {
		$newdata = json_encode($data, JSON_PRETTY_PRINT);
		file_put_contents($this->appreciations_filepath(), $newdata);
		return $data;
	}

	//
	// Retrieve the path to the JSON file
	//
	private function appreciations_filepath() {
		return kirby()->roots()->content() . DS . $this->appreciation_filename;
	}

	//
	// Get all appreciations as JSON object
	//
	private function get_all_appreciations() {
		$file =  file_get_contents($this->appreciations_filepath());
		return json_decode($file);
	}

	//
	// Get a single appreciation by id
	//
	private function get_appreciation($id) {
		$appreciations = $this->get_all_appreciations()->entries;
		foreach ($appreciations as $entry) {
			if ($entry->id == $id) {
				return $entry;
			}
		}
		return false;
	}

	//
	// Create an empty appriciation JSON file
	//
	private function create_appreciation_file() {
		$this->save_appreciations(array(
			'entries' => array()
		));
	}

	private function set_cookie($value) {
		$expires = false;
		$path = '/';
		$domain = c::get('url');
		setcookie($this->cookie_name, $value, $expires, $path);
	}

	private function get_cookie() {
		return isset($_COOKIE[$this->cookie_name]) ? $_COOKIE[$this->cookie_name] : false;
	}
	
	//
	// Add a comment to an appreciation entry
	//
	public function add_comment($id, $data) {
		$this->update_appreciation($data, $id);
	}
}