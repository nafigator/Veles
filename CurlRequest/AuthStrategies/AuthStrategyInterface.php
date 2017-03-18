<?php
/**
 * Auth strategies interface
 *
 * @file      AuthStrategyInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-01-20 21:22
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest\AuthStrategies;

use Veles\CurlRequest\CurlRequest;

/**
 * Interface AuthStrategyInterface
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
interface AuthStrategyInterface
{
	/**
	 * Sets headers for request for further authentication
	 *
	 * @param CurlRequest $request CurlRequest class
	 *
	 * @return bool
	 */
	public function apply(CurlRequest $request);
}
