<?php
/**
 * Interface for route strategies
 *
 * @file    iRouteStrategy.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Сбт Июн 23 10:06:37 2012
 * @license The BSD 3-Clause License
 *          <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Routing;

/**
 * Class iRouteStrategy
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface iRouteStrategy
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
