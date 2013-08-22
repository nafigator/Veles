<?php
/**
 * CacheAdapter singleton functionality
 *
 * @file    iCacheAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    8/22/13 16:20
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Drivers;

use Exception;

/**
 * Class CacheAdapterAbstract
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
abstract class CacheAdapterAbstract
{
	/** @var  mixed */
	protected $driver;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();

	final public function __call($method, $arguments)
	{
		if (!method_exists($this->driver, $method)) {
			throw new Exception('Calling non existent method!');
		}

		return call_user_func_array(array($this->driver, $method), $arguments);
	}
}