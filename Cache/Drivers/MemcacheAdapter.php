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
class MemcacheAdapter implements iCacheDriver
{
	private $memcache;

	/**
	 * Create Memcache class instance and connect to memcache pool
	 */
	final public function __construct()
	{
		if (!function_exists('memcache_add')) {
			throw new Exception('Memcache not installed!');
		}

		if (null === ($params = Config::getParams('memcache'))) {
			throw new Exception('Not found memcache parameters in config');
		}

		self::$instance = new Memcache;

		foreach ($params as $param) {
			if (!isset($param['port'])) {
				$param['port'] = 11211;
			}

			self::$instance->addserver($param['host'], $param['port']);
		}
	}

	/**
	 * Get Memcache instance
	 *
	 * @return Memcache
	 */
	private function getMemcache()
	{
		return $this->memcache;
	}

	/**
	 * Get data
	 * @param string $key Key
	 * @return mixed
	 */
	public function get($key)
	{
		return $this->getMemcache()->get($key);
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
		return $this->getMemcache()->set($key, $value, 0, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function has($key)
	{
		return (bool) $this->getMemcache()->get($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function del($key)
	{
		return $this->getMemcache()->delete($key);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear()
	{
		return $this->getMemcache()->flush();
	}
}