<?php
/**
 * @file    IniConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 12:08
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class IniConfigLoader
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class IniConfigLoader extends AbstractConfigLoader
{
	/**
	 * Load routes data from file
	 *
	 * return array
	 */
	public function load()
	{
		return parse_ini_file($this->getPath(), true);
	}
}
