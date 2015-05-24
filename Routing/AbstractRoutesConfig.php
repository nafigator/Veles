<?php
/**
 * @file      AbstractRoutesConfig.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-05-24 12:33
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class AbstractRoutesConfig
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
abstract class AbstractRoutesConfig
{
	protected $loader;

	/**
	 * Returns array that contains routes configuration
	 *
	 * @return array
	 */
	abstract public function getData();

	/**
	 * Sets strategy for config loader
	 *
	 * @param AbstractConfigLoader $loader Strategy of loading
	 */
	public function __construct(AbstractConfigLoader $loader)
	{
		$this->loader = $loader;
	}
}
