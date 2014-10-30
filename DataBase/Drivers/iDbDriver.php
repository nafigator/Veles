<?php
/**
 * Interface for data base interaction
 * @file      iDbDriver.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex@itvault.info>
 * @date      Вск Янв 06 10:13:35 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase\Drivers;

/**
 * Interface iDb
 * @todo Transfer connection pool into separate layer
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
interface iDbDriver
{
	/**
	 * Set current link to database server
	 *
	 * @param string $name Server name
	 */
	public static function setLink($name);

	/**
	 * Get database link
	 *
	 * @return mixed
	 */
	public static function getLink();

	/**
	 * Get database errors array
	 *
	 * return array
	 */
	public static function getErrors();

	/**
	 * Get FOUND_ROWS()
	 *
	 * Use only after query with DbPaginator
	 */
	public static function getFoundRows();

	/**
	 * Get LAST_INSERT_ID()
	 */
	public static function getLastInsertId();

	/**
	 * Method for execution non-SELECT queries
	 *
	 * @param string $sql    SQL-query
	 * @param string $server Server name
	 *
	 * @return bool
	 */
	public static function query($sql, $server = 'master');

	/**
	 * Method for SELECT returning one field value
	 *
	 * @param string $sql    SQL-query
	 * @param string $server Server name
	 *
	 * @return mixed
	 */
	public static function getValue($sql, $server = 'master');

	/**
	 * For SELECT, returning one row values
	 *
	 * @param string $sql    SQL-query
	 * @param string $server Server name
	 *
	 * @return array
	 */
	public static function getRow($sql, $server = 'master');

	/**
	 * For SELECT, returning collection
	 *
	 * @param string $sql    SQL-query
	 * @param string $server Server name
	 *
	 * @return array
	 */
	public static function getRows($sql, $server = 'master');

	/**
	 * Transaction begin
	 *
	 * @return bool
	 */
	public static function begin();

	/**
	 * Transaction rollback
	 *
	 * @return bool
	 */
	public static function rollback();

	/**
	 * Transaction commit
	 *
	 * @return bool
	 */
	public static function commit();
}
