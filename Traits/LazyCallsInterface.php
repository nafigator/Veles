<?php
/**
 * Interface that implements lazy calls functionality
 *
 * @file      LazyCallsInterface.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-03-05 18:56
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Traits;

interface LazyCallsInterface
{
	/**
	 * @return $this
	 */
	public static function instance();

	/**
	 * Collect calls which will be invoked during first real query
	 *
	 * @param $method
	 * @param $arguments
	 *
	 * @throws \Exception
	 */
	public function __call($method, $arguments);

	/**
	 * Save calls for future invocation
	 *
	 * @param string $method Method name that should be called
	 * @param array $arguments Method arguments
	 */
	public static function addCall($method, array $arguments = []);
}
