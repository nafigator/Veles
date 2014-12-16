<?php
/**
 * Base db-adapter class
 * @file    PdoConnection.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    2013-12-31 15:44
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase\Adapters;

use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\Helpers\Observable;

/**
 * Class DbAdapterBase
 *
 * Base class for Db adapters
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbAdapterBase extends Observable
{
	/** @var ConnectionPool */
	protected static $pool;
	/** @var  \PDO */
	protected static $connection;
	/** @var  string */
	protected static $connection_name;
	/** @var iDbAdapter */
	protected static $instance;

	/**
	 * Add connection pool
	 *
	 * @param ConnectionPool $pool
	 */
	public static function setPool(ConnectionPool $pool)
	{
		static::$pool = $pool;
		static::$connection_name = $pool->getDefaultConnectionName();
	}

	/**
	 * Get connection pool
	 *
	 * @return ConnectionPool $pool
	 */
	public static function getPool()
	{
		return static::$pool;
	}

	/**
	 * Set default connection
	 *
	 * @param string $name Connection name
	 *
	 * @return $this
	 */
	public function setConnection($name)
	{
		static::$connection_name = $name;
		static::$connection = null;

		return $this;
	}

	/**
	 * Get default connection resource
	 *
	 * return \PDO
	 */
	public function getConnection()
	{
		if (null === static::$connection) {
			$conn = static::$pool->getConnection(static::$connection_name);
			static::$connection = (null === $conn->getResource())
				? $conn->create()
				: $conn->getResource();
		}

		return static::$connection;
	}

	/**
	 * Get adapter instance
	 *
	 * @return iDbAdapter
	 */
	public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();

			static::$instance = new $class;
		}

		return static::$instance;
	}
}
