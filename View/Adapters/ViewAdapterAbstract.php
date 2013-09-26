<?php
/**
 * View adapter and singleton functionality
 *
 * @file    ViewAdapterAbstract.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Чтв Сен  5 15:10:46 MSK 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use Exception;

/**
 * Class ViewAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
abstract class ViewAdapterAbstract
{
	/** @var  null|array */
	protected static $calls;
	/** @var iViewAdapter|ViewAdapterAbstract */
	protected static $instance;
	/** @var  mixed */
	protected $driver;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();

	/**
	 * @return iViewAdapter|ViewAdapterAbstract
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
				array(self::$instance->getDriver(), $call['method']),
				$call['arguments']
			);
		}
		self::$calls = null;
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
		if (!method_exists($this->getDriver(), $method)) {
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