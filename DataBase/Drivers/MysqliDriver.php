<?php
/**
 * MySQLi driver for database interaction.
 * For usage you must have mysqli php extension
 * @file    MysqliDriver.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Мар 09 03:25:07 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase\Drivers;

use Exception;
use mysqli;
use Veles\Config;
use Veles\DataBase\DbException;
use Veles\DataBase\Drivers\iDbDriver;

/**
 * Class MysqliDriver
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class MysqliDriver implements iDbDriver
{
	private static $curr_link = null;
	private static $links     = array();
	private static $errors    = array();

	/**
	 * Set current link to server
	 *
	 * @param string $name Server name
	 */
	final public static function setLink($name)
	{
		if (!isset(self::$links[$name])) {
			self::connect($name);
		}

		self::$curr_link =& self::$links[$name];
	}

	/**
	 * Get database link
	 *
	 * @return mysqli
	 */
	public static function getLink()
	{
		if (!self::$curr_link instanceof mysqli) {
			self::connect('master');
			self::setLink('master');
		}

		return self::$curr_link;
	}

	/**
	 * Database connection
	 *
	 * Method create mysqli entity and save it in self::$curr_link
	 * @param string $name Server name
	 * @throws Exception
	 */
	private static function connect($name)
	{
		if (null === ($db_params = Config::getParams('db'))) {
			throw new Exception('Not found connection parameters in config');
		}

		if (!isset($db_params[$name])) {
			throw new Exception(
				"Not found connection parameters for server $name"
			);
		}

		self::$links[$name] = @mysqli_connect(
			$db_params[$name]['host'],
			$db_params[$name]['user'],
			$db_params[$name]['password'],
			$db_params[$name]['base']
		);

		if (!self::$links[$name] instanceof mysqli) {
			throw new Exception("Connetion failure to server $name");
		}
	}

	/**
	 * Method for execution non-SELECT queries
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 * @throws DbException
	 *
	 * @return bool
	 */
	final public static function query($sql, $server = 'master')
	{
		self::setLink($server);

		$result = mysqli_query(self::getLink(), $sql, MYSQLI_USE_RESULT);
		if (false === $result) {
			throw new DbException(
				'Query failure', self::getLink(), $sql
			);
		}

		return true;
	}

	/**
	 * Method for SELECT returning one field value
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 * @throws DbException
	 *
	 * @return string|bool
	 */
	final public static function getValue($sql, $server = 'master')
	{
		self::setLink($server);

		$result = mysqli_query(self::getLink(), $sql, MYSQLI_USE_RESULT);
		if (false === $result) {
			throw new DbException(
				'Не удалось выполнить запрос', self::getLink(), $sql
			);
		}

		$row = mysqli_fetch_row($result);

		mysqli_free_result($result);

		return isset($row[0]) ? $row[0] : false;
	}

	/**
	 * For SELECT, returning one row values
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 * @throws DbException
	 *
	 * @return array
	 */
	final public static function getRow($sql, $server = 'master')
	{
		self::setLink($server);

		$result = mysqli_query(self::getLink(), $sql, MYSQLI_USE_RESULT);
		if (false === $result) {
			throw new DbException(
				'Не удалось выполнить запрос', self::getLink(), $sql
			);
		}

		$return = mysqli_fetch_assoc($result);

		mysqli_free_result($result);

		return $return;
	}

	/**
	 * For SELECT, returning collection
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 * @throws DbException
	 *
	 * @return array
	 */
	final public static function getRows($sql, $server = 'master')
	{
		self::setLink($server);

		$result = mysqli_query(self::getLink(), $sql, MYSQLI_USE_RESULT);
		if (false === $result) {
			throw new DbException(
				'Не удалось выполнить запрос', self::getLink(), $sql
			);
		}

		$return = array();

		while ($row = mysqli_fetch_assoc($result)) {
			$return[] = $row;
		}

		mysqli_free_result($result);

		return $return;
	}

	/**
	 * Get LAST_INSERT_ID()
	 *
	 * @throws DbException
	 *
	 * @return int
	 */
	final public static function getLastInsertId()
	{
		$result = mysqli_insert_id(self::getLink());
		if (false === $result) {
			throw new DbException(
				'Не удалось получить LAST_INSERT_ID()', self::getLink()
			);
		}

		return (int) $result;
	}

	/**
	 * Get FOUND_ROWS()
	 *
	 * Use only after query with DbPaginator
	 * @throws DbException
	 *
	 * @return int
	 */
	final public static function getFoundRows()
	{
		$sql = 'SELECT FOUND_ROWS()';

		$result = mysqli_query(self::getLink(), $sql, MYSQLI_USE_RESULT);
		if (false === $result) {
			throw new DbException(
				'Не удалось выполнить запрос', self::getLink(), $sql
			);
		}

		$rows = mysqli_fetch_row($result);

		mysqli_free_result($result);

		return (int) $rows[0];
	}

	/**
	 * Get database errors array
	 *
	 * @return array
	 */
	final public static function getErrors()
	{
		return self::$errors;
	}

	/**
	 * Transaction begin
	 *
	 * @return bool
	 */
	public static function begin()
	{
		return mysqli_autocommit(self::getLink(), false);
	}

	/**
	 * Transaction rollback
	 *
	 * @return bool
	 */
	public static function rollback()
	{
		$link = self::getLink();

		$result = mysqli_rollback($link);
		mysqli_autocommit($link, true);

		return $result;
	}

	/**
	 * Transaction commit
	 *
	 * @return bool
	 */
	public static function commit()
	{
		$link = self::getLink();

		$result = mysqli_commit($link);
		mysqli_autocommit($link, true);

		return $result;
	}
}
