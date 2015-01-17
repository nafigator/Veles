<?php
/**
 * @file    CookieStrategyCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-26 22:24
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Auth\Strategies;

use Veles\Auth\Strategies\CookieStrategy;

/**
 * Class CookieStrategyCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class CookieStrategyCopy extends CookieStrategy
{
	protected static function delCookie()
	{
		return true;
	}
}
