<?php
/**
 * @file    PhpConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 12:17
 * @copyright The BSD 3-Clause License
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
