<?php
/**
 * Class for manipulation its properties
 *
 * @file      DynamicPropHandler.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault dot info>
 * @date      2015-02-05 06:34
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Traits;

/**
 * Trait DynamicPropHandler
 *
 * This trait is designed for support dynamic properties functionality
 * in classes. Parent class must be extended from StdClass
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
trait DynamicPropHandler
{
	/**
	 * Method for setting parameters
	 *
	 * @param   array Array with needle parameters as keys
	 *
	 * @return  $this
	 */
	public function setProperties(&$properties)
	{
		foreach ($properties as $property_name => $value) {
			$this->$property_name = $value;
		}

		return $this;
	}

	/**
	 * Method for getting parameters
	 *
	 * @param   array Array with needle parameters as keys
	 * @return  array
	 */
	public function getProperties(&$properties)
	{
		foreach (array_keys($properties) as $property_name) {
			if (isset($this->$property_name)) {
				$properties[$property_name] = $this->$property_name;
			}
		}
	}
}
