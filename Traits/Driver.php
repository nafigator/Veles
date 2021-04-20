<?php
/**
 * Driver handler
 *
 * @file      Driver.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-12-26 14:42
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Traits;

trait Driver
{
	/** @var  mixed */
	protected $driver;

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
	 *
	 * @return $this
	 */
	public function setDriver($driver)
	{
		$this->driver = $driver;

		return $this;
	}
}
