<?php
/**
 * RegEx routin processing
 * @file    RouteRegex.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Сбт Июн 23 10:47:39 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class RouteRegex
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class RouteRegex implements iRouteStrategy
{
	/**
	 * Variable contains array of named subpatterns values
	 *
	 * @var array
	 */
	protected static $map;

	/**
	 * Check if given url matches route pattern
	 *
	 * @param string $pattern Pattern from route config
	 * @param string $url current $_SERVER['REQUEST_URI'] without params
	 * @return bool
	 */
	public static function check($pattern, $url)
	{
		self::$map = null;
		$result = (bool) preg_match($pattern, $url, $matches);

		if (isset($matches[1])) {
			unset($matches[0]);

			self::$map = $matches;
		}

		return $result;
	}

	/**
	 * Get url maps
	 *
	 * @return mixed
	 */
	public static function getMap()
	{
		return self::$map;
	}
}
