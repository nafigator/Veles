<?php
/**
 * @file    LoginFormStrategyCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-26 23:04
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Auth\Strategies;

use Veles\Auth\Strategies\LoginFormStrategy;

/**
 * Class LoginFormStrategyCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class LoginFormStrategyCopy extends LoginFormStrategy
{
	protected static function setCookie($id, $hash)
	{
		return true;
	}

	protected static function delCookie()
	{
		return true;
	}
}
