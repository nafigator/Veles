<?php
/**
 * Cache adapter and singleton functionality
 *
 * @file    CacheAdapterAbstract.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    8/22/13 16:20
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Adapters;

use Exception;

/**
 * Class CacheAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
abstract class CacheAdapterAbstract
{
	/** @var  null|array */
	protected static $calls;
	/** @var iCacheAdapter|$this */
	protected static $instance;
	/** @var  mixed */
	protected $driver;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();

	/**
	 * @return iCacheAdapter|$this
	 */
	final public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();

			static::$instance = new $class;
		}

		if (null !== static::$calls) {
			static::invokeLazyCalls();
		}

		return static::$instance;
	}

	/**
	 * Lazy calls invocation
	 */
	final protected static function invokeLazyCalls()
	{
		foreach (static::$calls as $call) {
			call_user_func_array(
				array(static::$instance->getDriver(), $call['method']),
				$call['arguments']
			);
		}
		static::$calls = null;
	}

	/**
	 * Get adapter driver
	 *
	 * @return mixed
	 */
	final public function getDriver()
	{
		return $this->driver;
	}

	/**
	 * Set adapter driver
	 *
	 * @param mixed $driver
	 */
	final public function setDriver($driver)
	{
		$this->driver = $driver;
	}

	/**
	 * Save calls for future invocation
	 *
	 * @param string $method Method name that should be called
	 * @param array $arguments Method arguments
	 */
	final public static function addCall($method, array $arguments = array())
	{
		static::$calls[] = array(
			'method'    => $method,
			'arguments' => $arguments
		);
	}
}
