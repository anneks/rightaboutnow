<?php

abstract class BaseDatabaseFactory
{
	private $hostname;
	private $database;
	private $username;
	private $password;

	public function __construct($hostname, $database, $username, $password)
	{
		$this->hostname = $hostname;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
	}

	public function getConnection()
	{
		return new DatabaseConnection($this->hostname, $this->database, $this->username, $this->password);
	}
}
