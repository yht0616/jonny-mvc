<?php

namespace application\libraries\database;

interface database_driver_interface {

	public function select($values, $table_name, $where = NULL, $order_by = NULL);

}