<?php
/**
 * Базовый класс для работы с базой данных
 * @file    DbBase.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Срд Апр 23 06:34:47 MSK 2014
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use Exception;
use Veles\DataBase\Adapters\iDbAdapter;
use Veles\DataBase\Adapters\DbAdapterBase;

/**
 * Class DbBase
 *
 * Базовый класс для работы с базой данных
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbBase
{
	/** @var iDbAdapter */
	protected static $adapter;
	/** @var  string */
	protected static $adapter_name;
	/** @var  mixed */
	protected static $connection;
	/** @var  string */
	protected static $connection_name;

	/**
	 * Сохраняем имя класса адаптера для последующей инициализации
	 * Будет инициализирован при первом запросе данных из базы
	 *
	 * @param string $class_name Adapter name
	 * @see Db::getAdapter
	 */
	final public static function setAdapter($class_name = 'Pdo')
	{
		self::$adapter_name = "\\Veles\\DataBase\\Adapters\\${class_name}Adapter";
		self::$adapter = null;
	}

	/**
	 * Инстанс адаптера
	 *
	 * @throws Exception
	 * @return iDbAdapter
	 */
	final public static function getAdapter()
	{
		if (self::$adapter instanceof iDbAdapter) {
			return self::$adapter;
		}

		if (null === self::$adapter_name) {
			throw new Exception('Adapter not set!');
		}

		$tmp =& self::$adapter_name;
		self::$adapter = $tmp::instance();

		return self::$adapter;
	}

	/**
	 * Выбор соединения
	 *
	 * @param string $name Имя соединения
	 * @return DbAdapterBase
	 */
	final public static function connection($name)
	{
		return self::getAdapter()->setConnection($name);
	}

	/**
	 * Получение последнего сохранённого ID
	 *
	 * @return int
	 */
	final public static function getLastInsertId()
	{
		return self::getAdapter()->getLastInsertId();
	}

	/**
	 * Получение кол-ва строк в результате
	 *
	 * @return int
	 */
	final public static function getFoundRows()
	{
		return self::getAdapter()->getFoundRows();
	}

	/**
	 * Escaping variable
	 *
	 * @param string $var
	 * @return string
	 */
	final public static function escape($var)
	{
		return self::getAdapter()->escape($var);
	}
}
