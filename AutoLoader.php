<?php
/**
 * PSR-0 compatible class AutoLoader
 *
 * ATTENTION! Libraries dir must be in includes:
 * set_include_path(implode(PATH_SEPARATOR, [$path, get_include_path()]));
 *
 * @file      AutoLoader.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      Fri Jun 01 10:19:04 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles;

/**
 * Class AutoLoader
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class AutoLoader
{
	/**
	 * Initialisation
	 */
	public static function init()
	{
		spl_autoload_register(__NAMESPACE__ . '\AutoLoader::load');
	}

	/**
	 * AutoLoader
	 *
	 * @param string $class
	 */
	public static function load($class)
	{
		$file = preg_replace('/\\\|_(?!.+\\\)/', DIRECTORY_SEPARATOR, $class) . '.php';
		if (false !== ($full_path = stream_resolve_include_path($file))) {
			/** @noinspection PhpIncludeInspection */
			require $full_path;
		}
	}
}
