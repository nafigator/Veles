<?php
/**
 * Class for create view adapter
 *
 * @file    ViewFactory.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    2013-05-18 07:40
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View;

use Exception;
use Veles\Config;
use Veles\View\Adapters\iViewAdapter;

/**
 * Class ViewFactory
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ViewFactory
{
	/**
	 * Method for create view driver
	 * @throws Exception
	 * @return iViewDriver
	 */
	final public static function build()
	{
		if (null === ($class = Config::getParams('view_adapter'))) {
			throw new Exception('Not found View driver params in config!');
		}

		$class = ucfirst($class);
		$class_name = "\\Veles\\View\\Adapters\\{$class}Adapter";

		$driver = new $class_name;

		if (!$driver instanceof iViewAdapter) {
			throw new Exception('Not correct View driver!');
		}

		return new $driver;
	}
}
