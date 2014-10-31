<?php
/**
 * Adapter for APC cache
 *
 * @file    ApcAdapter.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Ноя 16 22:09:28 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Adapters;

use APCIterator;
use Exception;

/**
 * Class ApcAdapter
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ApcAdapter extends CacheAdapterAbstract implements iCacheAdapter
{
	/** @var  null|array */
	protected static $calls;
	/** @var iCacheAdapter|$this */
	protected static $instance;

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
	public function get($key)
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
	public function set($key, $value, $ttl = 0)
	{
		return apc_add($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function has($key)
	{
		return apc_exists($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function del($key)
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
	public function delByTemplate($tpl)
	{
		$result = false;

		foreach (new APCIterator('user', "/$tpl/") as $data) {
			$result = apc_delete($data['key']);
		}

		return $result;
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear()
	{
		return apc_clear_cache('user');
	}

	/**
	 * Increment key value
	 *
	 * @param string $key Key
	 * @param int $offset Offset
	 *
	 * @return bool|int
	 */
	public function increment($key, $offset)
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
	public function decrement($key, $offset)
	{
		return apc_dec($key, $offset);
	}
}
