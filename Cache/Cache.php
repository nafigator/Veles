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

use Veles\Cache\Adapters\iCacheAdapter;
use Veles\Config;

/**
 * Class Cache
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Cache
{
	/** @var iCacheAdapter */
	private static $adapter;

	/**
	 * Cache adapter initialisation
	 *
	 * @param string $adapter_name Adapter name
	 * @return iCacheAdapter
	 */
	final public static function setAdapter($adapter_name = 'Apc')
	{
		$adapter = "\\Veles\\Cache\\Adapters\\${adapter_name}Adapter";
		self::$adapter = $adapter::instance();

		return self::$adapter;
	}

	/**
	 * Cache adapter instance
	 *
	 * @return Cache
	 */
	private static function getAdapter()
	{
		if (self::$adapter instanceof iCacheAdapter) {
			return self::$adapter;
		}

		return self::setAdapter();
	}

	/**
	 * Get data
	 *
	 * @param string $key Key
	 * @return mixed
	 */
	final static public function get($key)
	{
		return self::getAdapter()->get($key);
	}

	/**
	 * Save date
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @param int $ttl Time to live
	 * @return bool
	 */
	final public static function set($key, $value, $ttl = 0)
	{
		return self::getAdapter()->set($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public static function has($key)
	{
		return self::getAdapter()->has($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public static function del($key)
	{
		return self::getAdapter()->del($key);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	final public static function clear()
	{
		return self::getAdapter()->clear();
	}

	/**
	 * Increment key value
	 *
	 * @param string $key
	 * @param int    $offset
	 *
	 * @return mixed
	 */final public static function increment($key, $offset = 1)
	{
		return self::getAdapter()->increment($key, $offset);
	}

	/**
	 * Decrement key value
	 *
	 * @param string $key
	 * @param int    $offset
	 * @return mixed
	 */final public static function decrement($key, $offset = 1)
	{
		return self::getAdapter()->decrement($key, $offset);
	}
}
