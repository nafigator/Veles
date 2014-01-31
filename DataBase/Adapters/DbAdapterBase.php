<?php
namespace Veles\DataBase\Adapters;

use Veles\DataBase\Connections\DbConnection;
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
	/** @var ConnectionPool[] */
	protected static $pool;
	/** @var  DbConnection */
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
	final public static function setPool(ConnectionPool $pool)
	{
		static::$pool = $pool;
		static::$connection_name = $pool->getDefaultConnectionName();
	}

	/**
	 * Get connection pool
	 *
	 * @return ConnectionPool $pool
	 */
	final public static function getPool()
	{
		return static::$pool;
	}

	/**
	 * Set default connection
	 *
	 * @param string $name Имя соединения
	 * @return $this
	 */
	final public function setConnection($name)
	{
		static::$connection_name = $name;
		static::$connection = null;

		return $this;
	}

	/**
	 * Get default connection resource
	 *
	 * return mixed
	 */
	final public function getConnection()
	{
		if (null === static::$connection) {
			$conn = static::$pool->getConnection(static::$connection_name);
			static::$connection = ($conn->getResource())
				?: $conn->create()->getResource();
		}

		return static::$connection;
	}

	/**
	 * Get adapter instance
	 *
	 * @return iDbAdapter
	 */
	final public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();

			static::$instance = new $class;
		}

		if (null !== static::$calls) {
			static::invokeLazyCalls();
		}

		return static::$instance;
	}

	/**
	 * Save calls for future invocation
	 *
	 * @param string $method Method name that should be called
	 * @param array $arguments Method arguments
	 */
	final public static function addCall($method, array $arguments = array())
	{
		static::$calls[] = array(
			'method'    => $method,
			'arguments' => $arguments
		);
	}

	/**
	 * Lazy calls invocation
	 */
	final public static function invokeLazyCalls()
	{
		foreach (static::$calls as $call) {
			call_user_func_array(
				array(static::$instance->getConnection(), $call['method']),
				$call['arguments']
			);
		}
		static::$calls = null;
	}
}
