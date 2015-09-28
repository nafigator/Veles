<?php
/**
 * @file    RouteCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-24 20:18
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\Routing;

use Veles\Routing\Route;

/**
 * Class RouteCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RouteCopy extends Route
{
	protected static $instance;

	public function unsetInstance()
	{
		static::$instance = null;
	}

	public static function getInstance()
	{
		return static::$instance;
	}
}
