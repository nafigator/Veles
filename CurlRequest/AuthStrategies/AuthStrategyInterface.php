<?php
/**
 * Auth strategies interface
 *
 * @file      AuthStrategyInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-01-20 21:22
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request\AuthStrategies;

use Veles\Request\CurlRequest;

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
