<?php
/**
 * Handler for processing static routes
 *
 * @file      RouteStatic.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Сбт Июн 23 10:42:18 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Routing;

/**
 * Class RouteStatic
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class RouteStatic implements iRouteStrategy
{
	/**
	 * Check for matching url to pattern
	 *
	 * @param string $pattern
	 * @param string $url
	 * @return bool
	 */
	public static function check($pattern, $url)
	{
		return $pattern === $url
			|| $pattern . 'index.php'  === $url
			|| $pattern . '/index.php' === $url;
	}
}
