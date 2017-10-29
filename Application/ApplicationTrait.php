<?php
/**
 * Trait for application object handling
 *
 * @file      ApplicationTrait.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2016-10-21 16:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

trait ApplicationTrait
{
	protected $application;

	/**
	 * Get application object
	 *
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * Set application
	 *
	 * @param mixed $application
	 *
	 * @return $this
	 */
	public function setApplication($application)
	{
		$this->application = $application;

		return $this;
	}
}
