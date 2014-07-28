<?php

interface IPdo
{
	/**
	 * @return bool
	 */
	public function beginTransaction();

	/**
	 * @return bool
	 */
	public function commit();

	/**
	 * @return mixed
	 */
	public function errorCode();

	/**
	 * @return mixed
	 */
	public function errorInfo();

	/**
	 * @param $statement string
	 * @return int
	 */
	public function exec($statement);

	/**
	 * @param $attribute int
	 * @return mixed
	 */
	public function getAttribute($attribute);

	/**
	 * @return array
	 */
	public static function getAvailableDrivers();

	/**
	 * @return bool
	 */
	public function inTransaction();

	/**
	 * @param string $name
	 * @return string
	 */
	public function lastInsertId($name = null);

	/**
	 * @param string $statement
	 * @param array $driver_options
	 * @return PDOStatement
	 */
	public function prepare($statement, array $driver_options);

	/**
	 * @param string $statement
	 * @return PDOStatement
	 */
	public function query($statement);

	/**
	 * @param string $string
	 * @param int $parameter_type
	 * @return string
	 */
	public function quote($string, $parameter_type = PDO::PARAM_STR);

	/**
	 * @return bool
	 */
	public function rollBack();

	/**
	 * @param int $attribute
	 * @param mixed $value
	 * @return bool
	 */
	public function setAttribute($attribute, $value);
}
