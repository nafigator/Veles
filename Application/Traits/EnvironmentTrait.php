<?php
/**
 * Trait for handling Environment object
 *
 * @file      EnvironmentTrait.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-11-05 09:57
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application\Traits;

use Veles\Application\Environment;

trait EnvironmentTrait
{
	/** @var  Environment */
	protected $environment;

	/**
	 * Set application environment
	 *
	 * @param Environment $environment
	 *
	 * @return $this
	 */
	public function setEnvironment(Environment $environment)
	{
		$this->environment = $environment;

		return $this;
	}

	/**
	 * Get environment object
	 *
	 * @return Environment
	 */
	public function getEnvironment()
	{
		return $this->environment;
	}
}
