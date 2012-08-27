<?php

namespace application\core;

class load {

	public $load;

	public function view($view_name, $data = NULL) {
		$this->load = $this;
		$view_location = APPLICATION_ROOT . 'setup' . DS . 'views' . DS . $view_name . '.php';

		if (file_exists($view_location) === TRUE) {
			include_once $view_location;
		}
	}

	public function partial($partial_name, $data = NULL) {
		$this->load = $this;
		$partial_name = ltrim($partial_name, '/');
		$partial_name = explode('/', $partial_name);
		$partial_name_count = count($partial_name) - 1;
		$partial_name[$partial_name_count] = '__' . $partial_name[$partial_name_count];
		$partial_name = implode('/', $partial_name);

		$partial_location = APPLICATION_ROOT . 'setup' . DS . 'views' . DS . $partial_name . '.php';

		if (file_exists($partial_location) === TRUE) {
			include_once $partial_location;
		}
	}

	public function library($library_name) {
		$library_location = APPLICATION_ROOT . 'extras/libraries/' . $library_name . '.php';

		if (file_exists($library_location) === TRUE) {
			include_once $library_location;
		}
	}

}