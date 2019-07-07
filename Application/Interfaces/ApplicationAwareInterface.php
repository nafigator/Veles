<?php
/**
 * Interface for handling application object
 *
 * @file      ApplicationAwareInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-02-20 05:04
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Application\Interfaces;

use Veles\Application\Application;

interface ApplicationAwareInterface
{
	/**
	 * Get application object
	 *
	 * @return Application
	 */
	public function getApplication();

	/**
	 * Set application
	 *
	 * @param Application $application
	 *
	 * @return $this
	 */
	public function setApplication(Application $application);
}
