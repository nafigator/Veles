<?php
/**
 * Handler for processing static routes
 *
 * @file      RouteStatic.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      Сбт Июн 23 10:42:18 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

/**
 * Class RouteStatic
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class RouteStatic implements RouteStrategyInterface
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
