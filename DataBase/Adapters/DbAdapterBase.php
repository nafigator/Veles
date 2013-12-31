<?php
namespace Veles\DataBase\Adapters;

use Veles\DataBase\Connections\DbConnection;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\Helpers\Observable;

/**
 * Class DbAdapterBase
 *
 * Общий базовый класс для Db адаптеров
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbAdapterBase extends Observable
{
	/** @var ConnectionPool[] */
	protected static $pool;
	/** @var  DbConnection */
	protected static $connection;
	/** @var  string */
	protected static $connection_name;
	/** @var iDbAdapter */
	protected static $instance;

	/**
	 * Добавление пула соединений
	 *
	 * @param ConnectionPool $pool
	 */
	final public static function setPool(ConnectionPool $pool)
	{
		static::$pool = $pool;
		static::$connection_name = $pool->getDefaultConnectionName();
	}

	/**
	 * Получение пула соединений
	 *
	 * @return ConnectionPool $pool
	 */
	final public static function getPool()
	{
		return static::$pool;
	}

	/**
	 * Установка соединения по-умолчанию
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
	 * Получение соединения по-умолчанию
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
	 * Возвращаем инстанс адаптера
	 *
	 * @return iDbAdapter
	 */
	final public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();

			static::$instance = new $class;
		}

		return static::$instance;
	}
}
