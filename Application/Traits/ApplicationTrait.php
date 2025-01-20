<?php
/**
 * Trait for application object handling
 *
 * @file      ApplicationTrait.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2016-10-21 16:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application\Traits;

use Veles\Application\Interfaces\ApplicationInterface;

trait ApplicationTrait
{
	protected $application;

	/**
	 * Get application object
	 *
	 * @return ApplicationInterface|static
	 */
	public function getApplication(): ApplicationInterface
	{
		return $this->application;
	}

	/**
	 * Set application
	 *
	 * @param ApplicationInterface $application
	 *
	 * @return static
	 */
	public function setApplication(ApplicationInterface $application)
	{
		$this->application = $application;

		return $this;
	}
}
