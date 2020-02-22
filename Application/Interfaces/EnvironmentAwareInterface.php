<?php
/**
 * Interface for handling Environment
 *
 * @file      EnvironmentAwareInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-01-04 08:32
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Application\Interfaces;

use Veles\Application\Environment;

interface EnvironmentAwareInterface
{
	/**
	 * Set application environment
	 *
	 * @param Environment $environment
	 *
	 * @return EnvironmentAwareInterface
	 */
	public function setEnvironment(Environment $environment);

	/**
	 * Get environment object
	 *
	 * @return Environment
	 */
	public function getEnvironment();
}
