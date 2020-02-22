<?php
/**
 * Class for database interaction
 *
 * @file      DbBase.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      Thu May 2 11:51:05 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase;

/**
 * Class Db
 *
 * Класс с методами обработки и вызова запросов
 * Типы плейсхолдеров указываются в mysqli-формате:
 * i - integer
 * d - float/double
 * s - string
 * b - binary
 * Если для плейсходеров не указываются типы, используется тип string
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Db extends DbTransactionHandler
{
	/**
	 * Получение значения столбца таблицы
	 *
	 * @param string      $sql    SQL-запрос
	 * @param array       $params Плейсхолдеры запроса
	 * @param string|null $types  Типы плейсхолдеров
	 *
	 * @return mixed Returns string or false on failure or empty result
	 * @throws \Exception
	 */
	public static function value($sql, array $params = [], $types = null)
	{
		return self::getAdapter()->value($sql, $params, $types);
	}

	/**
	 * Получение строки таблицы в виде ассоциативного массива
	 *
	 * @param string      $sql    SQL-запрос
	 * @param array       $params Плейсхолдеры запроса
	 * @param string|null $types  Типы плейсхолдеров
	 *
	 * @return mixed Returns array or false on failure or empty result
	 * @throws \Exception
	 */
	public static function row($sql, array $params = [], $types = null)
	{
		return self::getAdapter()->row($sql, $params, $types);
	}

	/**
	 * Получение результата в виде коллекции ассоциативных массивов
	 *
	 * @param string      $sql    SQL-запрос
	 * @param array       $params Плейсхолдеры запроса
	 * @param string|null $types  Типы плейсхолдеров
	 *
	 * @return mixed Returns array or false on failure
	 * @throws \Exception
	 */
	public static function rows($sql, array $params = [], $types = null)
	{
		return self::getAdapter()->rows($sql, $params, $types);
	}

	/**
	 * Запуск произвольного не SELECT запроса
	 *
	 * @param string      $sql    Non-SELECT SQL-запрос
	 * @param array       $params Плейсхолдеры запроса
	 * @param string|null $types  Типы плейсхолдеров
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public static function query($sql, array $params = [], $types = null)
	{
		return self::getAdapter()->query($sql, $params, $types);
	}
}
