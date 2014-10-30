<?php
/**
 * Class AutoLoader
 * @file    AutoLoader.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Fri Jun 01 10:19:04 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

/**
 * Class AutoLoader
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
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
		if (stream_resolve_include_path($file))
			/** @noinspection PhpIncludeInspection */
			require $file;
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
