<?php
namespace Veles\Tests\DataBase;

use Veles\DataBase\Db;

/**
 * Class DbCopy
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @group database
 */
class DbCopy extends Db
{
	public static function unsetAdapter()
	{
		self::$adapter = null;
	}
}
