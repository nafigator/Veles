<?php
namespace Veles\Tests\DataBase;

/**
 * Class Db
 *
 * Нужен для тестирования класса Db. В стандартном классе статические свойства
 * недоступны, поэтому добавил пару методов для доступа к ним.
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @group database
 */
class Db extends \Veles\DataBase\Db
{
	public static function unsetAdapter()
	{
		self::$adapter_name = null;
		self::$adapter 		= null;
	}
}
