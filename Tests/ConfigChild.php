<?php
/**
 * @file    ConfigChild.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-11-02 20:45
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests;

use Veles\Config;

/**
 * Class ConfigChild
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ConfigChild extends Config
{
	public static function dataCleanup()
	{
		self::$data = null;
	}
}
