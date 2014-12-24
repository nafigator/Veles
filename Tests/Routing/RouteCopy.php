<?php
/**
 * @file    RouteCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-12-24 20:18
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Routing;

use Veles\Routing\Route;

/**
 * Class RouteCopy
 * @author  Yancharuk Alexander <alex@itvault.info>
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
