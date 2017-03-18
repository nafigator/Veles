<?php
/**
 * Base class for database interaction
 *
 * @file      DbBase.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Срд Апр 23 06:34:47 MSK 2014
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase;

use Exception;
use Veles\DataBase\Adapters\DbAdapterInterface;

/**
 * Class DbBase
 *
 * Базовый класс для работы с базой данных
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class DbBase
{
	/** @var DbAdapterInterface */
	protected static $adapter;
	/** @var  mixed */
	protected static $connection;
	/** @var  string */
	protected static $connection_name;

	/**
	 * Set Db adapter
	 *
	 * @param DbAdapterInterface $adapter Adapter
	 *
	 * @see Db::getAdapter
	 */
	public static function setAdapter(DbAdapterInterface $adapter)
	{
		self::$adapter = $adapter;
	}

	/**
	 * Get Db adapter instance
	 *
	 * @throws Exception
	 *
	 * @return DbAdapterInterface
	 */
	public static function getAdapter()
	{
		if (null === self::$adapter) {
			throw new Exception('Adapter not set!');
		}

		return self::$adapter;
	}

	/**
	 * Choose connection
	 *
	 * @param string $name Connection name
	 *
	 * @return DbAdapterInterface
	 */
	public static function connection($name)
	{
		return self::getAdapter()->setConnection($name);
	}

	/**
	 * Getting last insert id
	 *
	 * @return int
	 */
	public static function getLastInsertId()
	{
		return self::getAdapter()->getLastInsertId();
	}

	/**
	 * Getting result rows count
	 *
	 * @return int
	 */
	public static function getFoundRows()
	{
		return self::getAdapter()->getFoundRows();
	}

	/**
	 * Escaping variable
	 *
	 * @param string $var
	 *
	 * @return string
	 */
	public static function escape($var)
	{
		return self::getAdapter()->escape($var);
	}
}
