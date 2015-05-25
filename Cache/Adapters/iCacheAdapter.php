<?php
/**
 * Cache adapters interface
 *
 * @file      iCacheAdapter.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Чтв Ноя 15 21:36:22 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Adapters;

/**
 * Interface iCacheAdapter
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface iCacheAdapter
{
	/**
	 * Get data
	 * @param string $key Key
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Save data
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @param int $ttl Time to live
	 * @return mixed
	 */
	public function set($key, $value, $ttl);

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function has($key);

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function del($key);

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
	public function delByTemplate($tpl);

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear();

	/**
	 * Increment key value
	 *
	 * @param string $key Key
	 * @param int $offset Offset
	 *
	 * @return bool|int
	 */
	public function increment($key, $offset);

	/**
	 * Decrement key value
	 *
	 * @param string $key Keys
	 * @param int $offset Offset
	 * @return bool|int
	 */
	public function decrement($key, $offset);
}
