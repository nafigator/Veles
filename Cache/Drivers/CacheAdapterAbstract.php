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

	/** @var  null|array */
	protected static $calls;

	/** @var iCacheAdapter */
	protected static $instance;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();

	/**
	 * @return iCacheAdapter
	 */
	final public static function instance()
	{
		if (null === self::$instance) {
			$class = get_called_class();

			self::$instance = new $class;
		}

		if (null !== self::$calls) {
			self::invokeLazyCalls();
		}

		return self::$instance;
	}

	/**
	 * Lazy calls invocation
	 */
	final protected static function invokeLazyCalls()
	{
		foreach (self::$calls as $call) {
			call_user_func_array(
				array(self::$instance->driver, $call['method']),
				$call['arguments']
			);
		}
		self::$calls = null;
	}

	/**
	 * Collect calls which will be invoked during first real query
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	final public function __call($method, $arguments)
	{
		if (!method_exists($this->driver, $method)) {
			throw new Exception('Calling non existent method!');
		}

		self::setCall($method, $arguments);
	}

	/**
	 * Save calls for future invocation
	 *
	 * @param $method
	 * @param $arguments
	 */
	private static function setCall($method, $arguments)
	{
		self::$calls[] = array(
			'method'    => $method,
			'arguments' => $arguments
		);
	}
}
