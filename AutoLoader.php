<?php
/**
 * PSR-4 compatible class AutoLoader
 *
 * @file      AutoLoader.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Fri Jun 01 10:19:04 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
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
		if (false !== ($full_path = stream_resolve_include_path($file)))
			/** @noinspection PhpIncludeInspection */
			require $full_path;
	}

	/**
	 * Add path to directory contained classes that should be loaded
	 *
	 * @param $path
	 */
	public static function registerPath($path)
	{
		if (is_array($path)) {
			$path = implode(PATH_SEPARATOR, $path);
		}

		set_include_path(
			implode(PATH_SEPARATOR, [$path, get_include_path()])
		);
	}
}
