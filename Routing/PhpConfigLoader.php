<?php
/**
 * Class-loader for routes config in php array format
 *
 * @file    PhpConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date    2015-05-24 12:17
 * @license The BSD 3-Clause License
 *          <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Routing;

/**
 * Class PhpConfigLoader
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class PhpConfigLoader extends AbstractConfigLoader
{
	/**
	 * Load routes data from file
	 *
	 * return array
	 */
	public function load()
	{
		/** @noinspection PhpIncludeInspection */
		return include $this->getPath();
	}
}
