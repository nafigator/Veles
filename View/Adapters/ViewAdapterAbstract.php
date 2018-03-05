<?php
/**
 * View adapter and singleton functionality
 *
 * @file      ViewAdapterAbstract.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      Чтв Сен  5 15:10:46 MSK 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\View\Adapters;

use Traits\DriverInterface;
use Traits\LazyCallsInterface;
use Traits\SingletonInstanceInterface;
use Veles\Traits\LazyCalls;

/**
 * Class ViewAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class ViewAdapterAbstract implements
	LazyCallsInterface,
	DriverInterface,
	SingletonInstanceInterface
{
	/** @var mixed */
	protected $variables = [];

	use LazyCalls;

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
