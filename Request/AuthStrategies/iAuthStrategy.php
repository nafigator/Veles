<?php
/**
 * @file    iAuthStrategy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-01-20 21:22
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Request\AuthStrategies;

use Veles\Request\CurlRequest;

/**
 * Interface iAuthStrategy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
interface iAuthStrategy
{
	/**
	 * Sets headers for request for further authentication
	 *
	 * @param CurlRequest $request Request class
	 *
	 * @return bool
	 */
	public function apply(CurlRequest $request);
}
