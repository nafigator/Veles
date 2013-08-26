<?php
/**
 * Adapter for Memcached
 *
 * @file    MemcachedAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    8/21/13 18:42
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Drivers;

use Exception;
use Memcached;
use Veles\Config;

/**
 * Class MemcachedAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class MemcachedAdapter extends CacheAdapterAbstract implements iCacheAdapter
{
	/**
	 * Create Memcached class instance and connect to memcached pool
	 */
	final protected function __construct()
	{
		if (!class_exists('Memcached')) {
			throw new Exception('Memcached not installed!');
		}

		$this->driver = new Memcached;
	}

	/**
	 * Get data
	 * @param string $key Key
	 * @return mixed
	 */
	public function get($key)
	{
		return $this->driver->get($key);
	}

	/**
	 * Save data
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @param int $ttl Time to live
	 * @return bool
	 */
	public function set($key, $value, $ttl = 0)
	{
		return $this->driver->set($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function has($key)
	{
		return (bool) $this->driver->get($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function del($key)
	{
		return $this->driver->delete($key);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear()
	{
		return $this->driver->flush();
	}
}
