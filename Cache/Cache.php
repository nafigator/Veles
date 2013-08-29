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
use Exception;

/**
 * Class Cache
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Cache
{
	/** @var iCacheAdapter */
	private static $adapter;

	/** @var  string */
	private static $adapter_name;

	/**
	 * Cache adapter initialisation
	 *
	 * @param string $class_name Adapter name
	 * @return iCacheAdapter
	 */
	final public static function setAdapter($class_name = 'Apc')
	{
		self::$adapter_name = "\\Veles\\Cache\\Adapters\\${class_name}Adapter";
	}

	/**
	 * Cache adapter instance
	 *
	 * @throws Exception
	 * @return iCacheAdapter
	 */
	private static function getAdapter()
	{
		if (self::$adapter instanceof iCacheAdapter) {
			return self::$adapter;
		}

		if (null === self::$adapter_name) {
			throw new Exception('Adapter not set!');
		}

		self::$adapter = new self::$adapter_name;

		return self::$adapter;
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
