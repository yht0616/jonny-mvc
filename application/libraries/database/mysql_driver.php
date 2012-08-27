<?php

namespace application\libraries\database;

class mysql_driver extends database_driver implements database_driver_interface {

	public function __construct() {
		parent::__construct();
	}

	private function connect() {
		try {
			return new \PDO('mysql:host=' . $this->host_name . ';dbname=' . $this->database_name, $this->username, $this->password);
		} catch (\PDOException $exception) {
			$error = new \application\core\error_log($exception->getMessage(), 'database', __FILE__);
			$error->do_error_log();
		}
	}

	public function select($columns, $table_name, $where = NULL, $order_by = NULL, $distinct = FALSE) {
		try {
			$this->database_connect = $this->connect();

			if ($distinct === TRUE) {
				$sql_query = 'SELECT DISTINCT ';
			} else {
				$sql_query = 'SELECT ';
			}
			if (is_array($columns) === TRUE) {
				for ($i = 0; $i < count($columns); $i++) {
					$sql_query .= $columns[$i] . ',';
				}
				$sql_query = rtrim($sql_query, ',');
			} else {
				$sql_query .= $columns;
			}
			$sql_query .= ' FROM ' . $table_name;
			if ($where !== NULL) {
				$sql_query .= ' WHERE ' . $where;
			}
			if ($order_by !== NULL) {
				$sql_query .= ' ORDER BY ' . $order_by;
			}
			$sql_query .= ';';
			$prepare_sql = $this->database_connect->prepare($sql_query);
			$prepare_sql->setFetchMode(\PDO::FETCH_ASSOC);

			$rows = array();
			if (($execute = $prepare_sql->execute()) !== FALSE) {
				if (($result = $prepare_sql->fetchAll()) !== FALSE) {
					return $result;
				} else {
					return FALSE;
				}
			}
		} catch (\PDOException $exception) {
			$error = new \application\core\error_log($exception->getMessage(), 'database', __FILE__);
			$error->do_error_log();
		}
	}

	public function insert($table_name, $array_with_values) {
		try {
			$this->database_connect = $this->connect();

			$sql_query = 'INSERT INTO ' . $table_name . ' (';
			foreach ($array_with_values as $key => $value) {
				$sql_query .= $key . ",";
			}
			$sql_query = rtrim($sql_query, ',');
			$sql_query .= ') VALUES (';
			foreach ($array_with_values as $key => $value) {
				if (is_string($value) === TRUE) {
					$sql_query .= "'" . $value . "',";
				} else {
					$sql_query .= $value . ',';
				}
			}
			$sql_query = rtrim($sql_query, ',');
			$sql_query .= ');';
			$prepare_sql = $this->database_connect->prepare($sql_query);

			if (($result = $prepare_sql->execute()) !== FALSE) {
				return $result;
			} else {
				return FALSE;
			}
		} catch (\PDOException $exception) {
			$error = new \application\core\error_log($exception->getMessage(), 'database', __FILE__);
			$error->do_error_log();
		}
	}

	public function update($table_name, $array_with_values, $where = NULL) {
		try {
			$this->database_connect = $this->connect();

			$sql_query = 'UPDATE ' . $table_name . ' SET ';
			foreach ($array_with_values as $key => $value) {
				if (is_string($value) === TRUE) {
					$sql_query .= $key . " = '" . $value . "', ";
				} else {
					$sql_query .= $key . ' = ' . $value . ', ';
				}
			}
			$sql_query = rtrim($sql_query, ', ');
			if ($where !== NULL) {
				$sql_query .= ' WHERE ' . $where;
			}
			$sql_query .= ';';
			$prepare_sql = $this->database_connect->prepare($sql_query);

			if (($result = $prepare_sql->execute()) !== FALSE) {
				return $result;
			} else {
				return FALSE;
			}
		} catch (\PDOException $exception) {
			$error = new \application\core\error_log($exception->getMessage(), 'database', __FILE__);
			$error->do_error_log();
		}
	}

	public function delete($table_name, $where = NULL) {
		try {
			$this->database_connect = $this->connect();

			$sql_query = 'DELETE FROM ' . $table_name;
			if ($where !== NULL) {
				$sql_query .= ' WHERE ' . $where;
			}
			$sql_query .= ';';
			$prepare_sql = $this->database_connect->prepare($sql_query);

			if (($result = $prepare_sql->execute()) !== FALSE) {
				return $result;
			} else {
				return FALSE;
			}
		} catch (\PDOException $exception) {
			$error = new \application\core\error_log($exception->getMessage(), 'database', __FILE__);
			$error->do_error_log();
		}
	}

	public function query($sql_query) {
		try {
			$this->database_connect = $this->connect();

			$sql_query = rtrim($sql_query, ';');
			$sql_query .= ';';
			$prepare_sql = $this->database_connect->prepare($sql_query);

			if (($result = $prepare_sql->execute()) !== FALSE) {
				return $result;
			} else {
				return FALSE;
			}
		} catch (\PDOException $exception) {
			$error = new \application\core\error_log($exception->getMessage(), 'database', __FILE__);
			$error->do_error_log();
		}
	}

}