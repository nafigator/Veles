<?php
/**
 * Cache adapters interface
 *
 * @file    iCacheAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Чтв Ноя 15 21:36:22 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Drivers;

/**
 * Interface iCacheAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
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
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear();
}
