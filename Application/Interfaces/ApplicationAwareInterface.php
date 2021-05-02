<?php
/**
 * Interface for handling application object
 *
 * @file      ApplicationAwareInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-02-20 05:04
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application\Interfaces;

interface ApplicationAwareInterface
{
	/**
	 * Get application object
	 *
	 * @return ApplicationInterface
	 */
	public function getApplication(): ApplicationInterface;

	/**
	 * Set application
	 *
	 * @param ApplicationInterface $application
	 *
	 * @return static
	 */
	public function setApplication(ApplicationInterface $application);
}
