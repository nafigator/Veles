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

namespace Veles\Cache\Adapters;

use Exception;
use Memcached;
use Veles\Cache\Adapters\CacheAdapterAbstract;

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

		$this->setDriver(new Memcached);
	}

	/**
	 * Get data
	 * @param string $key Key
	 * @return mixed
	 */
	final public function get($key)
	{
		return $this->getDriver()->get($key);
	}

	/**
	 * Save data
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @param int $ttl Time to live
	 * @return bool
	 */
	final public function set($key, $value, $ttl)
	{
		return $this->getDriver()->set($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public function has($key)
	{
		return (bool) $this->getDriver()->get($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	final public function del($key)
	{
		return $this->getDriver()->delete($key);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	final public function clear()
	{
		return $this->getDriver()->flush();
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
		return $this->getDriver()->increment($key, $offset);
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
		return $this->getDriver()->decrement($key, $offset);
	}
}
