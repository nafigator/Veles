<?php
/**
 * Interface for dynamic properties handling
 *
 * @file      DynamicPropHandlerInterface.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-03-05 19:02
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Traits;

interface DynamicPropHandlerInterface
{
	/**
	 * Method for setting parameters
	 *
	 * @param   array $properties Array with needle parameters as keys
	 *
	 * @return  $this
	 */
	public function setProperties(array $properties);

	/**
	 * Method for getting parameters
	 *
	 * @param   array $properties Array with needle parameters as keys
	 */
	public function getProperties(array &$properties);

	/**
	 * Method for getting array filled with initialized properties
	 *
	 * @return array
	 */
	public function toArray();
}
