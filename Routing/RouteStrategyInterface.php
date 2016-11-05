<?php
/**
 * Interface for route strategies
 *
 * @file    RouteStrategyInterface.php
 *
 * PHP version 5.6+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date    Сбт Июн 23 10:06:37 2012
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

/**
 * Class RouteStrategyInterface
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface RouteStrategyInterface
{
	/**
	 * Method for checking current url
	 *
	 * @param string $url
	 * @param string $pattern
	 *
	 * @return bool
	 */
	public static function check($url, $pattern);
}
