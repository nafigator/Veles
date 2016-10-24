<?php
/**
 * Class-loader for routes config in php array format
 *
 * @file      PhpConfigLoader.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      2015-05-24 12:17
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
