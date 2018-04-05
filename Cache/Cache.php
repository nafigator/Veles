<?php
/**
 * Cache class
 *
 * @file      Cache.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      Птн Ноя 16 20:42:01 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache;

use Exception;
use Veles\Cache\Traits\CacheAdapterTrait;

/**
 * Class Cache
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Cache
{
	use CacheAdapterTrait;

	/**
	 * Get data
	 *
	 * @param string $key Key
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public static function get($key)
	{
		return self::getAdapter()->get($key);
	}

	/**
	 * Save date
	 *
	 * @param string $key   Key
	 * @param mixed  $value Data
	 * @param int    $ttl   Time to live
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function set($key, $value, $ttl = 0)
	{
		return self::getAdapter()->set($key, $value, $ttl);
	}

	/**
	 * Save date if key not exists
	 *
	 * @param string $key   Key
	 * @param mixed  $value Data
	 * @param int    $ttl   Time to live
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function add($key, $value, $ttl = 0)
	{
		return self::getAdapter()->add($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function has($key)
	{
		return self::getAdapter()->has($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function del($key)
	{
		return self::getAdapter()->del($key);
	}

	/**
	 * Method for deletion keys by template
	 *
	 * ATTENTION: if key contains spaces, for example 'THIS IS KEY::ID:50d98ld',
	 * then in cache it will be saved as 'THIS_IS_KEY::ID:50d98ld'. So, template
	 * for that key deletion must be look like - 'THIS_IS_KEY'.
	 * Deletion can be made by substring, containing in keys. For example
	 * '_KEY::ID'.
	 *
	 * @param string $tpl Substring containing in needed keys
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function delByTemplate($tpl)
	{
		return self::getAdapter()->delByTemplate($tpl);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 * @throws Exception
	 */
	public static function clear()
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
	 * @throws Exception
	 */
	public static function increment($key, $offset = 1)
	{
		return self::getAdapter()->increment($key, $offset);
	}

	/**
	 * Decrement key value
	 *
	 * @param string $key
	 * @param int    $offset
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public static function decrement($key, $offset = 1)
	{
		return self::getAdapter()->decrement($key, $offset);
	}
}
