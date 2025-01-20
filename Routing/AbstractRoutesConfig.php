<?php
/**
 * Base class for routes config
 *
 * @file      AbstractRoutesConfig.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-05-24 12:33
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
	 * Returns array that contains routes configuration
	 *
	 * @param string $name Name of section
	 *
	 * @return array
	 */
	abstract public function getSection($name);

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
