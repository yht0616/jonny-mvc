<?php

namespace application\core;

class model {

	private $database_driver;
	private $configuration, $database_configuration;
	protected $driver_class;
	public $database;

	public function __construct() {
		$this->database_configuration = new \setup\configuration\database();

		switch ($this->database_configuration->use) {
			case 'testing':
				$this->configuration = $this->database_configuration->testing;
				break;
			case 'development':
				$this->configuration = $this->database_configuration->development;
				break;
			case 'production':
				$this->configuration = $this->database_configuration->production;
				break;
			default:
				$error_message = 'Could not get the database configurations';
				$log_error = new \application\core\error_log($error_message, 'logic', __FILE__);
				$log_error->do_error_log();
				break;
		}

		$database_driver = APPLICATION_ROOT . 'application' . DS . 'libraries' . DS . 'database' . DS . $this->configuration['driver'] . '_driver.php';
		$this->database_driver = $database_driver;
		if (file_exists($this->database_driver) === TRUE) {
			require_once $this->database_driver;
			$driver = '\application\libraries\database\\' . $this->configuration['driver'] . '_driver';
			$this->driver_class = new $driver();
			$this->database = $this->driver_class;
		}
	}

}