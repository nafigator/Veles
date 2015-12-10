<?php
/**
 * View adapter and singleton functionality
 *
 * @file      ViewAdapterAbstract.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Чтв Сен  5 15:10:46 MSK 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\View\Adapters;

use Exception;

/**
 * Class ViewAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class ViewAdapterAbstract
{
	/** @var  null|array */
	protected static $calls;
	/** @var ViewAdapterAbstract */
	protected static $instance;
	/** @var  mixed */
	protected $driver;
	/** @var mixed */
	protected $variables;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	abstract public function show($path);

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	abstract public function get($path);

	/**
	 * Check template cache status
	 *
	 * @param string $tpl Template file
	 * @return bool Cache status
	 */
	abstract public function isCached($tpl);

	/**
	 * @return $this
	 */
	public static function instance()
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
				[static::$instance->getDriver(), $call['method']],
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
	public function getDriver()
	{
		return $this->driver;
	}

	/**
	 * Set adapter driver
	 *
	 * @param mixed $driver
	 */
	public function setDriver($driver)
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
	public function __call($method, $arguments)
	{
		if (!method_exists($this->getDriver(), $method)) {
			throw new Exception('Calling non existent method!');
		}

		static::setCall($method, $arguments);
	}

	/**
	 * Save calls for future invocation
	 *
	 * @param $method
	 * @param $arguments
	 */
	protected static function setCall($method, $arguments)
	{
		static::$calls[] = [
			'method'    => $method,
			'arguments' => $arguments
		];
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables or traversable class
	 */
	public function set($vars = [])
	{
		foreach ($vars as $prop => $value) {
			$this->variables[$prop] = $value;
		}
	}

	/**
	 * Output variables cleanup
	 *
	 * @param array $vars Array of variables names
	 */
	public function del(array $vars)
	{
		foreach ($vars as $var_name) {
			if (isset($this->variables[$var_name])) {
				unset($this->variables[$var_name]);
			}
		}
	}
}
