<?php
/**
 * Базовый класс для работы с базой данных
 * @file    DbBase.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Срд Апр 23 06:34:47 MSK 2014
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use Exception;
use Veles\DataBase\Adapters\DbAdapterBase;
use Veles\DataBase\Adapters\iDbAdapter;

/**
 * Class DbBase
 *
 * Базовый класс для работы с базой данных
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class DbBase
{
	/** @var iDbAdapter */
	protected static $adapter;
	/** @var  mixed */
	protected static $connection;
	/** @var  string */
	protected static $connection_name;

	/**
	 * Сохраняем имя класса адаптера для последующей инициализации
	 * Будет инициализирован при первом запросе данных из базы
	 *
	 * @param iDbAdapter $adapter Adapter
	 * @see Db::getAdapter
	 */
	public static function setAdapter(iDbAdapter $adapter)
	{
		self::$adapter = $adapter;
	}

	/**
	 * Инстанс адаптера
	 *
	 * @throws Exception
	 * @return iDbAdapter
	 */
	public static function getAdapter()
	{
		if (null === self::$adapter) {
			throw new Exception('Adapter not set!');
		}

		return self::$adapter;
	}

	/**
	 * Выбор соединения
	 *
	 * @param string $name Имя соединения
	 * @return DbAdapterBase
	 */
	public static function connection($name)
	{
		return self::getAdapter()->setConnection($name);
	}

	/**
	 * Получение последнего сохранённого ID
	 *
	 * @return int
	 */
	public static function getLastInsertId()
	{
		return self::getAdapter()->getLastInsertId();
	}

	/**
	 * Получение кол-ва строк в результате
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
	 * @return string
	 */
	public static function escape($var)
	{
		return self::getAdapter()->escape($var);
	}
}
