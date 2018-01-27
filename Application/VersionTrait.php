<?php
/**
 * Trait for handling version set and get methods
 *
 * @file      VersionTrait.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      2016-01-15 18:46
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Application;

trait VersionTrait
{
	/** @var  string */
	protected $version;

	/**
	 * Get application version
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * Set application version
	 *
	 * @param string $version
	 *
	 * @return $this
	 */
	public function setVersion($version)
	{
		$this->version = $version;

		return $this;
	}
}
