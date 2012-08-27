<?php

namespace application\libraries\database;

class database_driver {

	protected $configuration;
	protected $database_connect;
	protected $host_name, $username, $password, $database_name;

	public function __construct() {
		$database_configuration = new \setup\configuration\database();
		switch ($database_configuration->use) {
			case 'testing':
				$this->configuration = $database_configuration->testing;
				break;
			case 'development':
				$this->configuration = $database_configuration->development;
				break;
			case 'production':
				$this->configuration = $database_configuration->production;
				break;
			default:
				$error_message = 'Could not get the database configuration info';
				$log_error = new \application\core\error_log($error_message, 'logic', __FILE__);
				$log_error->do_error_log();
				break;
		}

		$this->host_name = $this->configuration['host_name'];
		$this->username = $this->configuration['username'];
		$this->password = $this->configuration['password'];
		$this->database_name = $this->configuration['database_name'];
	}

}