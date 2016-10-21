<?php
/**
 * RegEx routing processing
 *
 * @file      RouteRegex.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      Сбт Июн 23 10:47:39 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

/**
 * Class RouteRegex
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class RouteRegex implements RouteStrategyInterface
{
	/**
	 * Variable contains array of named sub-patterns values
	 *
	 * @var array|null
	 */
	protected static $params;

	/**
	 * Check if given url matches route pattern
	 *
	 * @param string $pattern Pattern from route config
	 * @param string $url     current $_SERVER['REQUEST_URI'] without params
	 *
	 * @return bool
	 */
	public static function check($pattern, $url)
	{
		self::$params = null;

		if (1 === ($result = preg_match($pattern, $url, $matches))) {
			self::unsetNumericKeys($matches);

			self::$params = $matches;
		}

		return (bool) $result;
	}

	/**
	 * Get url maps
	 *
	 * @return mixed
	 */
	public static function getParams()
	{
		return self::$params;
	}

	protected static function unsetNumericKeys(&$matches)
	{
		foreach (array_keys($matches) as $key) {
			if (is_int($key)) {
				unset($matches[$key]);
			}
		}
	}
}
