<?php

namespace application\core;

class error_log {

	private $error_message, $error_type, $triggered_from;
	private $error_types_location = array(
		'file_system' => 'file_system_log.txt',
		'database' => 'database_log.txt',
		'logic' => 'logic_log.txt',
	);
	private $general_error_location = 'overview_log.txt';
	private $all_logs_error_location = 'all_logs.txt';
	private $error_logs_folder;

	public function __construct($error_message = NULL, $error_type = NULL, $file_triggered = NULL) {
		$this->error_logs_folder = APPLICATION_ROOT . 'extras' . DS . 'management' . DS . 'error_logs';
		$this->error_message = strtolower($error_message);
		$this->error_type = $error_type;
		$this->triggered_from = $file_triggered;
	}

	public function do_error_log() {
		$log_path = $this->error_logs_folder . DS . $this->error_types_location[$this->error_type];
		$all_logs_path = $this->error_logs_folder . DS . $this->all_logs_error_location;

		$error_file = fopen($log_path, 'a+');
		$all_logs_file = fopen($all_logs_path, 'a+');

		$full_error_message = 'on [' . date('l, M. j, Y', time()) . '] at [' . date('g:i:sA T', time()) . '], the following error occurred:' . PHP_EOL;
		$full_error_message .= "\t" . 'error message: ' . $this->error_message . PHP_EOL;
		$full_error_message .= "\t" . 'triggered by: "' . $this->triggered_from . '"' . PHP_EOL;
		$full_error_message .= PHP_EOL;
		$all_logs_error_message = 'on [' . date('l, M. j, Y', time()) . '] at [' . date('g:i:sA T', time()) . '], the following error occurred and was added to <' . $this->error_types_location[$this->error_type] . '>:' . PHP_EOL;
		$all_logs_error_message .= "\t" . 'error message: ' . $this->error_message . PHP_EOL;
		$all_logs_error_message .= "\t" . 'triggered by: "' . $this->triggered_from . '"' . PHP_EOL;
		$all_logs_error_message .= "\r\n";

		$write_error = fwrite($error_file, $full_error_message);
		if ($write_error !== FALSE) {
			$general_log_path = $this->error_logs_folder . DS . $this->general_error_location;

			$general_error_file = fopen($general_log_path, 'a+');

			$full_general_error_message = date('l, M. j, Y | g:i:sA T', time()) . ':' . PHP_EOL;
			$full_general_error_message .= "\t" . 'new log entry added to "' . $this->error_type . '" log =>' . PHP_EOL;
			$full_general_error_message .= "\t" . '|->' . "\t" . '"' . $this->error_types_location[$this->error_type] . '"' . PHP_EOL;
			$full_general_error_message .= "\t" . '|->' . "\t" . 'log file location: "' . $log_path . '"' . PHP_EOL;
			$full_general_error_message .= PHP_EOL;

			fwrite($general_error_file, $full_general_error_message);
			fclose($general_error_file);
		}

		fwrite($all_logs_file, $all_logs_error_message);
		fclose($error_file);
		fclose($all_logs_file);
	}

	public function clear_log_file($error_type) {
		$log_path = $this->error_logs_folder . DS . $this->error_types_location[$error_type];
		$error_file = fopen($log_path, 'w+');
		fwrite($error_file, '');
		fclose($error_file);
	}

	public function clear_all_log_files() {
		foreach (glob(APPLICATION_ROOT . 'extras' . DS . 'management' . DS . 'error_logs' . DS . '*.txt') as $log_file) {
			$log_file = fopen($log_file, 'w+');
			fwrite($log_file, '');
			fclose($log_file);
		}
	}

}