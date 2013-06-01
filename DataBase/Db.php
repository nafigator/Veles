<?php
/**
 * Calss for database interaction
 * @file    Db.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Янв 06 11:48:07 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use Veles\DataBase\DbFabric;
use Veles\DataBase\Drivers\iDbDriver;

/**
 * Class Db
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Db implements iDbDriver
{
	/**
	 * Driver instance
	 *
	 * @return iDbDriver
	 */
	private static function getDriver()
	{
		/**
		 * @var iDbDriver
		 */
		static $driver;

		if (null === $driver) {
			$driver = DbFabric::getDriver();
		}

		return $driver;
	}

	/**
	 * Set current link to database server
	 *
	 * @param string $name Server name
	 */
	public static function setLink($name)
	{
		return self::getDriver()->setLink();
	}

	/**
	 * Transaction begin
	 *
	 * @return bool
	 */
	public static function begin()
	{
		return self::getDriver()->begin();
	}

	/**
	 * Transaction rollback
	 *
	 * @return bool
	 */
	public static function rollback()
	{
		return self::getDriver()->rollback();
	}

	/**
	 * Transaction commit
	 *
	 * @return bool
	 */
	public static function commit()
	{
		return self::getDriver()->commit();
	}

	/**
	 * Get database link
	 *
	 * @return mixed
	 */
	final public static function getLink()
	{
		return self::getDriver()->getLink();
	}

	/**
	 * Get database errors array
	 *
	 * @return array
	 */
	final public static function getErrors()
	{
		return self::getDriver()->getErrors();
	}

	/**
	 * Get FOUND_ROWS()
	 *
	 * Use after query with DbPaginator
	 *
	 * @return array
	 */
	final public static function getFoundRows()
	{
		return self::getDriver()->getFoundRows();
	}

	/**
	 * Get LAST_INSERT_ID()
	 *
	 * @return int
	 */
	final public static function getLastInsertId()
	{
		return self::getDriver()->getLastInsertId();
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
		return self::getDriver()->query($sql, $server);
	}

	/**
	 * Method for SELECT returning one field value
	 *
	 * @param string $sql SQL-query
	 * @param string $server Server name
	 *
	 * @return mixed
	 */
	final public static function getValue($sql, $server = 'master')
	{
		return self::getDriver()->getValue($sql, $server);
	}

	/**
	 * For SELECT, returning one row values
	 *
	 * @param string $sql SQL-qury
	 * @param string $server Server name
	 *
	 * @return array
	 */
	final public static function getRow($sql, $server = 'master')
	{
		return self::getDriver()->getRow($sql, $server);
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
		return self::getDriver()->getRows($sql, $server);
	}
}
