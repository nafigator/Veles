<?php
/**
 * Class AutoLoader
 * @file    AutoLoader.php
 *
 * PHP version 5.3.9+
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
	final public static function init()
	{
		spl_autoload_register(__NAMESPACE__ . '\AutoLoader::load');
	}

	/**
	 * AutoLoader
	 *
	 * @param string $class_name
	 */
	final public static function load($class_name)
	{
		$class_name = ltrim($class_name, '\\');
		$namespace = $file_name = '';
		if ($last_ns_pos = strrpos($class_name, '\\')) {
			$namespace = substr($class_name, 0, $last_ns_pos);
			$class_name = substr($class_name, $last_ns_pos + 1);
			$file_name  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$file_name = stream_resolve_include_path(
			$file_name . str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php'
		);

		if ($file_name) {
			/** @noinspection PhpIncludeInspection */
			include $file_name;
		}
	}
}
