<?php
/**
 * Adapter for APC cache
 *
 * @file    ApcAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Ноя 16 22:09:28 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Adapters;

use Exception;
use APCIterator;

/**
 * Class ApcAdapter
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ApcAdapter extends CacheAdapterAbstract implements iCacheAdapter
{
	/**
	 * Constructor
	 */
	final protected function __construct()
	{
		if (!function_exists('apc_add')) {
			throw new Exception('APC cache not installed!');
		}
	}

	/**
	 * Get data
	 * @param string $key Key
	 * @return mixed
	 */
	final public function get($key)
	{
		return apc_fetch($key);
	}

	/**
	 * Save data
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @param int $ttl Time to live
	 * @return mixed
	 */
	final public function set($key, $value, $ttl = 0)
	{
		return apc_add($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public function has($key)
	{
		apc_exists($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public function del($key)
	{
		return apc_delete($key);
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
	 * @return bool
	 */
	final public function delByTemplate($tpl)
	{
		return apc_delete(new APCIterator('user', "/$tpl/"));
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	final public function clear()
	{
		return apc_clear_cache();
	}

	/**
	 * Increment key value
	 *
	 * @param string $key Key
	 * @param int $offset Offset
	 *
	 * @return bool|int
	 */
	final public function increment($key, $offset)
	{
		return apc_inc($key, $offset);
	}

	/**
	 * Decrement key value
	 *
	 * @param string $key Key
	 * @param int $offset Offset
	 *
	 * @return bool|int
	 */
	final public function decrement($key, $offset)
	{
		return apc_dec($key, $offset);
	}
}
