<?php
/**
 * Класс, содержащий функционал транзакций
 * @file    DbTransactionHandler.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Срд Апр 23 06:34:47 MSK 2014
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

/**
 * Class DbTransactionHandler
 *
 * Класс, содержащий функционал транзакций
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbTransactionHandler extends DbBase
{
	/**
	 * Инициализация транзакции
	 *
	 * @return bool
	 */
	public static function begin()
	{
		return self::getAdapter()->begin();
	}

	/**
	 * Откат транзакции
	 *
	 * @return bool
	 */
	public static function rollback()
	{
		return self::getAdapter()->rollback();
	}

	/**
	 * Сохранение всех запросов транзакции и её закрытие
	 *
	 * @return bool
	 */
	public static function commit()
	{
		return self::getAdapter()->commit();
	}
}
