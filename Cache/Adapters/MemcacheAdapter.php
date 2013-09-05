<?php
/**
 * Adapter for Memcache
 *
 * @file    MemcacheAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    8/21/13 12:54
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Adapters;

use Exception;
use Memcache;
use Veles\Cache\Adapters\CacheAdapterAbstract;

/**
 * Class MemcacheAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class MemcacheAdapter extends CacheAdapterAbstract implements iCacheAdapter
{
	/**
	 * Create Memcache class instance and connect to memcache pool
	 */
	final protected function __construct()
	{
		if (!class_exists('Memcache')) {
			throw new Exception('Memcache not installed!');
		}

		$this->setDriver(new Memcache);
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
		return $this->getDriver()->set($key, $value, 0, $ttl);
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
