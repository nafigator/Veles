<?php
/**
 * Interface for handling version
 *
 * @file      VersionAwareInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-02-20 05:13
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Application\Interfaces;

interface VersionAwareInterface
{
	/**
	 * Get application version
	 *
	 * @return string
	 */
	public function getVersion();

	/**
	 * Set application version
	 *
	 * @param string $version
	 *
	 * @return $this
	 */
	public function setVersion($version);
}
