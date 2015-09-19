<?php
/**
 * Class for manipulation its properties
 *
 * @file      DynamicPropHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-02-05 06:34
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Traits;

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
	 * @return  array
	 */
	public function setProperties(&$properties)
	{
		foreach ($properties as $property_name => $value) {
			$this->$property_name = $value;
		}
	}

	/**
	 * Method for getting parameters
	 *
	 * @param   array Array with needle parameters as keys
	 * @return  array
	 */
	public function getProperties(&$properties)
	{
		$tmp_props = array_keys($properties);
		foreach ($tmp_props as $property_name) {
			if (isset($this->$property_name)) {
				$properties[$property_name] = $this->$property_name;
			}
		}
	}
}
