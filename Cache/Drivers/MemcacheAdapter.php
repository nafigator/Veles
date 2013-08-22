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

namespace Veles\Cache\Drivers;

use Exception;
use Memcache;
use Veles\Config;

/**
 * Class MemcacheAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class MemcacheAdapter extends CacheAdapterAbstract implements iCacheAdapter
{
	/** @var iCacheAdapter */
	private static $instance;

	/**
	 * Create Memcache class instance and connect to memcache pool
	 */
	final protected function __construct()
	{
		if (!class_exists('Memcache')) {
			throw new Exception('Memcache not installed!');
		}

		$this->driver = new Memcache;
	}

	/**
	 * @return iCacheAdapter
	 */
	final public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();
			static::$instance = new $class;
		}

		return static::$instance;
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
		return $this->driver->set($key, $value, 0, $ttl);
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