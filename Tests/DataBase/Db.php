<?php
namespace Veles\Tests\DataBase;

/**
 * Class Db
 *
 * Нужен для тестирования класса Db. В стандартном классе статические свойства
 * недоступны, поэтому добавил пару методов для доступа к ним.
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @group database
 */
class Db extends \Veles\DataBase\Db
{
	public static function unsetAdapter()
	{
		self::$adapter = null;
	}
}
