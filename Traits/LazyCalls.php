<?php
/**
 * Save some calls of driver for future real query invocation
 *
 * @file      LazyCalls.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-12-26 13:38
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Traits;

use Exception;

trait LazyCalls
{
	/** @var  array */
	protected static $calls = [];

	use Driver;
	use SingletonInstance;

	/**
	 * Lazy calls invocation
	 */
	protected static function invokeLazyCalls()
	{
		[$calls, static::$calls] = [static::$calls, []];

		foreach ($calls as $call) {
			call_user_func_array(
				[static::instance()->getDriver(), $call['method']],
				$call['arguments']
			);
		}
	}

	/**
	 * @return $this
	 */
	public static function instance()
	{
		if (null === static::$instance) {
			$class = static::class;

			static::$instance = new $class;
		}

		if ([] !== static::$calls) {
			static::invokeLazyCalls();
		}

		return static::$instance;
	}

	/**
	 * Collect calls which will be invoked during first real query
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @throws Exception
	 */
	public function __call($method, $arguments)
	{
		if (!method_exists($this->getDriver(), $method)) {
			throw new Exception('Calling non existent method!');
		}

		static::addCall($method, $arguments);
	}

	/**
	 * Save calls for future invocation
	 *
	 * @param string $method Method name that should be called
	 * @param array $arguments Method arguments
	 */
	public static function addCall($method, array $arguments = [])
	{
		static::$calls[] = [
			'method'    => $method,
			'arguments' => $arguments
		];
	}
}
