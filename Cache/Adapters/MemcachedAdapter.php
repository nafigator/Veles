<?php
/**
 * Adapter for Memcached
 *
 * @file      MemcachedAdapter.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      8/21/13 18:42
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

use Memcached;

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
