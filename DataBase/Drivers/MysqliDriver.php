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
	 *
	 * @return bool
	 */
	final public static function query($sql, $server = 'master')
	{
		self::setLink($server);
		$link = self::getLink();

		$result = mysqli_query($link, $sql, MYSQLI_USE_RESULT);

		if (false === $result) {
			self::$errors[] = mysqli_error($link);
		}

		return $result;
	}

	/**
	 * Method for SELECT returning one field value
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 *
	 * @return string|bool
	 */
	final public static function getValue($sql, $server = 'master')
	{
		self::setLink($server);
		$link = self::getLink();

		$result = mysqli_query($link, $sql, MYSQLI_USE_RESULT);

		if (false !== $result) {
			$row = mysqli_fetch_row($result);
			$return = isset($row[0]) ? $row[0] : '';
		} else {
			self::$errors[] = mysqli_error($link);
			$return = false;
		}

		mysqli_free_result($result);

		return $return;
	}

	/**
	 * For SELECT, returning one row values
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 *
	 * @return array
	 */
	final public static function getRow($sql, $server = 'master')
	{
		self::setLink($server);
		$link = self::getLink();

		$result = mysqli_query($link, $sql, MYSQLI_USE_RESULT);
		if (false !== $result) {
			$return = mysqli_fetch_assoc($result);
		} else {
			self::$errors[] = mysqli_error($link);
			$return = false;
		}

		mysqli_free_result($result);

		return $return;
	}

	/**
	 * For SELECT, returning collection
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 *
	 * @return array
	 */
	final public static function getRows($sql, $server = 'master')
	{
		self::setLink($server);
		$link = self::getLink();

		$result = mysqli_query($link, $sql, MYSQLI_USE_RESULT);
		if (false !== $result) {
			$return = array();

			while ($row = mysqli_fetch_assoc($result)) {
				$return[] = $row;
			}
		} else {
			self::$errors[] = mysqli_error($link);
			$return = false;
		}

		mysqli_free_result($result);

		return $return;
	}

	/**
	 * Get LAST_INSERT_ID()
	 *
	 * @return int
	 */
	final public static function getLastInsertId()
	{
		return (int) mysqli_insert_id(self::getLink());;
	}

	/**
	 * Get FOUND_ROWS()
	 *
	 * Use only after query with DbPaginator
	 *
	 * @return int
	 */
	final public static function getFoundRows()
	{
		$sql  = 'SELECT FOUND_ROWS()';
		$link = self::getLink();

		$result = mysqli_query($link, $sql, MYSQLI_USE_RESULT);
		if (false !== $result) {
			$return = (null !== ($rows = mysqli_fetch_row($result)))
				? (int) $rows[0]
				: 0;
		} else {
			self::$errors[] = mysqli_error($link);
			$return = false;
		}

		mysqli_free_result($result);

		return $return;
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
