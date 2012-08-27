<?php

class pages_controller extends \application\core\controller {

	public function __construct() {
		parent::__construct();
	}

	public function home($first_name = NULL, $last_name = NULL) {
		if ($first_name === NULL || $last_name === NULL) {
			print 'hey!';
		} else {
			print 'hello, ' . $first_name . ' ' . $last_name;
			$data = array(
				'first_name' => 'Jonathan',
				'last_name' => 'Barronville',
			);
			$this->load->view('somefile', $data);
		}
	}

}