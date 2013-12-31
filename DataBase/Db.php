<?php
namespace Veles\DataBase;

use Exception;
use Veles\DataBase\Adapters\iDbAdapter;
use Veles\DataBase\Adapters\DbAdapterBase;

/**
 * Class Db
 *
 * Класс для работы с базой данных
 * Типы плейсхолдеров указываются в mysqli-формате:
 * i - integer
 * d - float/double
 * s - string
 * b - binary
 * Если для плейсходеров не указываются типы, используется тип string
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Db
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
	 * Получение значения столбца таблицы
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return string
	 */
	public static function value($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->value($sql, $params, $types);
	}

	/**
	 * Получение строки таблицы в виде ассоциативного массива
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return array
	 */
	final public static function row($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->row($sql, $params, $types);
	}

	/**
	 * Получение результата в виде коллекции ассоциативных массивов
	 *
	 * @param string $sql SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return mixed
	 */
	final public static function rows($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->rows($sql, $params, $types);
	}

	/**
	 * Инициализация транзакции
	 *
	 * @return bool
	 */
	final public static function begin()
	{
		return self::getAdapter()->begin();
	}

	/**
	 * Откат транзакции
	 *
	 * @return bool
	 */
	final public static function rollback()
	{
		return self::getAdapter()->rollback();
	}

	/**
	 * Сохранение всех запросов транзакции и её закрытие
	 *
	 * @return bool
	 */
	final public static function commit()
	{
		return self::getAdapter()->commit();
	}

	/**
	 * Запуск произвольного не SELECT запроса
	 *
	 * @param string $sql Non-SELECT SQL-запрос
	 * @param array $params Плейсхолдеры запроса
	 * @param string|null $types Типы плейсхолдеров
	 * @return bool
	 */
	final public static function query($sql, array $params = array(), $types = null)
	{
		return self::getAdapter()->query($sql, $params, $types);
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
