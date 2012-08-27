<?php

namespace setup\configuration;

class database {

	public $use = 'testing';

	public $testing = array(
		'driver' => 'mysql',
		'host_name' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database_name' => 'pseudofake',
	);

	public $development = array(
		'driver' => 'mysql',
		'host_name' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database_name' => '',
	);

	public $production = array(
		'driver' => 'mysql',
		'host_name' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database_name' => '',
	);

}