<?php
/**
 * @file    PdoAdapterCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-09-20 16:50
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\DataBase\Adapters;

use Veles\DataBase\Adapters\PdoAdapter;


/**
 * Class PdoAdapterCopy
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class PdoAdapterCopy extends PdoAdapter
{
	public static function getCalls()
	{
		return self::$calls;
	}

	public static function setCalls(array $calls)
	{
		self::$calls = $calls;
	}

	public static function resetCalls()
	{
		self::$calls = null;
	}

	public static function unsetInstance()
	{
		self::$instance = null;
	}
}
