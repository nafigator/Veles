<?php
/**
 * @file    RouteRegexChild.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-12-22 13:56
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Routing;

use Veles\Routing\RouteRegex;

/**
 * Class RouteRegexChild
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class RouteRegexChild extends RouteRegex
{
	public static function setMap($map)
	{
		self::$map = $map;
	}
}
