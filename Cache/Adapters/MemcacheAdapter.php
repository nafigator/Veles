<?php
/**
 * Adapter for Memcache
 *
 * @file      MemcacheAdapter.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      8/21/13 12:54
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

use Exception;
use Memcache;

/**
 * Class MemcacheAdapter
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class MemcacheAdapter extends CacheAdapterAbstract implements CacheAdapterInterface
{
	/** @var  null|array */
	protected static $calls;
	/** @var CacheAdapterInterface */
	protected static $instance;

	/**
	 * Create Memcache class instance and connect to memcache pool
	 */
	protected function __construct()
	{
		$this->setDriver(new Memcache);
	}

	/**
	 * Get data
	 *
	 * @param string $key Key
	 * @return mixed
	 */
	public function get($key)
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
	public function set($key, $value, $ttl)
	{
		return $this->getDriver()->set($key, $value, 0, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function has($key)
	{
		return (bool) $this->getDriver()->get($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function del($key)
	{
		return $this->getDriver()->delete($key);
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
		try {
			$cache = new MemcacheRaw();
			$cache->delByTemplate($tpl)->disconnect();
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear()
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
