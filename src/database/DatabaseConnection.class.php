<?php

class DatabaseConnection
{
	private $hostname;
	private $database;
	private $username;
	private $password;

	/**
	 * @var IPdo
	 */
	private $pdo;

	public function __construct($hostname, $database, $username, $password)
	{
		$this->hostname = $hostname;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
	}

	protected function connect()
	{
		if (is_null($this->pdo))
		{
			$this->pdo = new PDO("mysql:dbname={$this->database};host={$this->hostname}", $this->username, $this->password, array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			));
		}
	}

	protected function disconnect()
	{
		if (!is_null($this->pdo))
		{
			// nothing to do
		}
	}

	/**
	 * @param string $query
	 * @param array $parameters
	 * @return array
	 */
	public function getSingle($query, array $parameters = array())
	{
		$this->connect();

		$sth = $this->pdo->prepare($query, array());
		$sth->execute($parameters);
		//file_put_contents('/tmp/get_debug', $sth->queryString."\n", FILE_APPEND);
		return $sth->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 * @param string $query
	 * @param array $parameters
	 * @return array
	 */
	public function getAll($query, array $parameters = array())
	{
		$this->connect();

		//file_put_contents('/tmp/get_debug', print_r($parameters, true)."\n", FILE_APPEND);
		$sth = $this->pdo->prepare($query, array());
		$sth->execute($parameters);
		//file_put_contents('/tmp/get_debug', $sth->queryString."\n", FILE_APPEND);
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param string $query
	 * @param array $parameters
	 */
	public function update($query, array $parameters = array())
	{
		$this->connect();

		$sth = $this->pdo->prepare($query, array());
		$sth->execute($parameters);
	}
}
