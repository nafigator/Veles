<?php
/**
 * @file    iRoutesConfig.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 12:33
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Interface iRoutesConfig
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
interface iRoutesConfig
{
	/**
	 * Returns array that contains routes configuration
	 *
	 * @return array
	 */
	public function getData();

	/**
	 * Sets strategy for config loader
	 *
	 * @param RouteConfigLoader $loader Strategy of loading
	 *
	 * @return $this
	 */
	public function setLoader(RouteConfigLoader $loader);
}
