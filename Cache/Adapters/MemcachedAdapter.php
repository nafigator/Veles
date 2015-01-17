<?php
/**
 * Adapter for Memcached
 *
 * @file    MemcachedAdapter.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    8/21/13 18:42
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Adapters;

use Exception;
use Memcached;
use Veles\Cache\Adapters\MemcacheAdapter;

/**
 * Class MemcachedAdapter
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class MemcachedAdapter extends MemcacheAdapter
{
    /** @var  null|array */
    protected static $calls;
    /** @var iCacheAdapter */
    protected static $instance;

	/**
	 * Create Memcached class instance and connect to memcached pool
	 */
	protected function __construct()
	{
		$this->setDriver(new Memcached);
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
		return $this->getDriver()->set($key, $value, $ttl);
	}
}
