<?php

namespace application\core;

class route {

	public $path, $uri, $default_route, $configuration_route;

	public function __construct($path, $uri = NULL) {
		$this->path = $path;
		$this->uri = $uri;
		$this->configuration_route = new \setup\configuration\route();
		$this->default_route = $this->configuration_route->default_location;
	}

	public function do_route() {
		if ($this->path === '' || $this->path === NULL || $this->path === '/') {
			header('Location: ' . SERVER_PATH . 'index.php/' . $this->default_route);
		}

		$this->path = trim($this->path, '/');
		$this->path = explode('/', $this->path);

		$file_names = array(
			APPLICATION_ROOT . 'setup' . DS . 'controllers' . DS . $this->path[0] . '.php',
			APPLICATION_ROOT . 'setup' . DS . 'models' . DS . $this->path[0] . '.php',
		);
		foreach ($file_names as $file_name) {
			if (file_exists($file_name)) {
				require_once $file_name;
			} else {
				$error_message = 'The file "' . $file_name . '" does not exist';
				$log_error = new \application\core\error_log($error_message, 'file_system', __FILE__);
				$log_error->do_error_log();
			}
		}

		if (array_key_exists(0, $this->path) === TRUE) {
			$controller_class = $this->path[0] . '_controller';
			if (class_exists($controller_class) === TRUE) {
				if (method_exists($controller_class, 'before_filter') === TRUE) {
					$controller_class::before_filter($this->path);
				}

				$controller = new $controller_class();

				$arguments = array_slice($this->path, 2);
				if (array_key_exists(1, $this->path) === TRUE) {
					$controller_method = $this->path[1];
					if (method_exists($controller, $controller_method) === TRUE) {
						call_user_func_array(array($controller, $controller_method), $arguments);
					} else {
						$error_message = 'The method "' . $controller_method . '" was not found in the class "' . $controller_class . '"';
						$log_error = new \application\core\error_log($error_message, 'file_system', __FILE__);
						$log_error->do_error_log();
						header('Location: ' . SERVER_PATH . 'index.php/' . $this->default_route);
					}
				}

				if (method_exists($controller, 'after_filter') === TRUE) {
					$controller->after_filter();
				}
			} else {
				$error_message = 'The class "' . $controller_class . '" does not exist';
				$log_error = new \application\core\error_log($error_message, 'file_system', __FILE__);
				$log_error->do_error_log();
				header('Location: ' . SERVER_PATH . 'index.php/' . $this->default_route);
			}
		}

		if (file_exists(APPLICATION_ROOT . '.htaccess') === TRUE) {
			if ($this->uri === 'index.php') {
				$redirect_location = implode('/', $this->path);
				header('Location: ' . SERVER_PATH . $redirect_location);
			}
		}
	}

}