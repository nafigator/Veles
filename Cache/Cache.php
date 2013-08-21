<?php
/**
 * Cache class
 *
 * @file    Cache.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Ноя 16 20:42:01 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache;

use Veles\Cache\Drivers\iCacheDriver;
use Veles\Config;

/**
 * Class Cache
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Cache
{
	private static $driver;

	/**
	 * Cache driver initialisation
	 *
	 * @param string $driver_name Driver name
	 * @return iCacheDriver
	 */
	final public static function init($driver_name = 'Apc')
	{
		$driver_class = "\\Veles\\Cache\\Drivers\\${driver_name}Adapter";
		self::$driver = new $driver_class;

		return self::$driver;
	}

	/**
	 * Cache instance
	 *
	 * @return Cache
	 */
	final public static function getDriver()
	{
		if (self::$driver instanceof iCacheDriver) {
			return self::$driver;
		}

		return self::init();
	}

	/**
	 * Get data
	 *
	 * @param string $key Key
	 * @return mixed
	 */
	final static public function get($key)
	{
		return self::getDriver()->get($key);
	}

	/**
	 * Save date
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @return bool
	 */
	final public static function set($key, $value)
	{
		return self::getDriver()->set($key, $value);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public static function has($key)
	{
		return self::getDriver()->has($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public static function del($key)
	{
		return self::getDriver()->del($key);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	final public static function clear()
	{
		return self::getDriver()->clear();
	}
}
