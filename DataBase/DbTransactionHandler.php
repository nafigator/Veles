<?php
/**
 * Class for transaction management
 *
 * @file      DbTransactionHandler.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Срд Апр 23 06:34:47 MSK 2014
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase;

/**
 * Class DbTransactionHandler
 *
 * Класс, содержащий функционал транзакций
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class DbTransactionHandler extends DbBase
{
	/**
	 * Transaction initialization
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public static function begin()
	{
		return self::getAdapter()->begin();
	}

	/**
	 * Rollback transaction
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public static function rollback()
	{
		return self::getAdapter()->rollback();
	}

	/**
	 * Apply all queries and close transaction
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public static function commit()
	{
		return self::getAdapter()->commit();
	}
}
