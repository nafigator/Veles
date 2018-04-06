<?php
/**
 * Interface for ActiveRecord SQL-table names handler
 *
 * @file      TableNameHandler.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      Пт Апр 6 11:58:04 2018
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model\Traits;

trait TableNameHandler
{
	/**
	 * Get table name prepared for sql usage
	 *
	 * @return string
	 */
	public function getEscapedTableName()
	{
		return '"' . static::TBL_NAME . '"';
	}
}
