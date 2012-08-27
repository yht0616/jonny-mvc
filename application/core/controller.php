<?php

namespace application\core;

class controller {

	public $load, $database;

	public function __construct() {
		$this->load = new \application\core\load();
		$model = new \application\core\model();
		$this->database = $model->database;
	}

}