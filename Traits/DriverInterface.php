<?php
/**
 *
 *
 * @file      DriverInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-01-16 05:14
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Traits;

interface DriverInterface
{
	/**
	 * Get adapter driver
	 *
	 * @return mixed
	 */
	public function getDriver();

	/**
	 * Set adapter driver
	 *
	 * @param mixed $driver
	 *
	 * @return static
	 */
	public function setDriver($driver);
}
