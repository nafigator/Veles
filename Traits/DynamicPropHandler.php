<?php
/**
 * Class for manipulation its properties
 *
 * @file      DynamicPropHandler.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
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
	 * @param   array $properties Array with needle parameters as keys
	 *
	 * @return  $this
	 */
	public function setProperties(array $properties)
	{
		foreach ($properties as $property_name => $value) {
			$this->$property_name = $value;
		}

		return $this;
	}

	/**
	 * Method for getting parameters
	 *
	 * @param   array $properties Array with needle parameters as keys
	 *
	 * @return  array
	 */
	public function getProperties(array &$properties)
	{
		foreach (array_keys($properties) as $property_name) {
			if (isset($this->$property_name)) {
				$properties[$property_name] = $this->$property_name;
			}
		}
	}

	/**
	 * Method for getting array filled with initialized properties
	 *
	 * @return array
	 */
	public function toArray()
	{
		$result = [];

		foreach (array_keys($this->map) as $property_name) {
			if (isset($this->$property_name)) {
				$result[$property_name] = $this->$property_name;
			}
		}

		return $result;
	}
}
