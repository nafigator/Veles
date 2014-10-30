<?php
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
	/** @var  null|array */
	protected static $calls;
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
	 * @param string $name Имя соединения
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
				? $conn->create(static::$calls)->getResource()
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

	/**
	 * Save calls for future invocation
	 *
	 * @param string $method Method name that should be called
	 * @param array $arguments Method arguments
	 */
	public static function addCall($method, array $arguments = array())
	{
		static::$calls[] = array(
			'method'    => $method,
			'arguments' => $arguments
		);
	}
}
