<?php
/**
 * @file    RouteRegexChild.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-22 13:56
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\Routing;

use Veles\Routing\RouteRegex;

/**
 * Class RouteRegexChild
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RouteRegexChild extends RouteRegex
{
	public static function setParams($params)
	{
		self::$params = $params;
	}
}
