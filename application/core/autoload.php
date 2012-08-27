<?php

namespace application\core;

class autoload {

	private $classes, $libraries, $required_files, $configuration_autoload;

	public function __construct() {
		$this->configuration_autoload = new \setup\configuration\autoload();
		$this->libraries = $this->configuration_autoload->autoload_libraries;
		$this->required_files = array(
			'application' . DS . 'core' . DS . 'controller',
			'application' . DS . 'core' . DS . 'model',
			'application' . DS . 'core' . DS . 'route',
			'application' . DS . 'core' . DS . 'error_log',
			'setup' . DS . 'configuration' . DS . 'autoload',
			'setup' . DS . 'configuration' . DS . 'database',
			'setup' . DS . 'configuration' . DS . 'route',
			'application' . DS . 'libraries' . DS . 'database',
		);

		for ($i = 0; $i <= (count($this->libraries) - 1); $i++) {
			$this->libraries[$i] = 'extras' . DS . 'libraries' . DS . $this->libraries[$i];
		}
		$this->classes = array_merge($this->libraries, $this->required_files);
	}

	public function do_autoload() {
		for ($i = 0; $i <= (count($this->classes) - 1); $i++) {
			$file_name = APPLICATION_ROOT . $this->classes[$i];
			if (is_dir($file_name) === TRUE) {
				foreach (glob($file_name . DS . '*.php') as $file) {
					require_once $file;
				}
			} else {
				$file_name .= '.php';
				if (file_exists($file_name) === TRUE) {
					include_once $file_name;
				} else {
					$error_message = 'The file "' . $file_name . '" does not exist';
					$log_error = new \application\core\error_log($error_message, 'file_system', __FILE__);
					$log_error->do_error_log();
				}
			}
		}
	}

}