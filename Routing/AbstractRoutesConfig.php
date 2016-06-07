<?php
/**
 * Base class for routes config
 *
 * @file      AbstractRoutesConfig.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
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
	 * Sets strategy for config loader
	 *
	 * @param AbstractConfigLoader $loader Strategy of loading
	 */
	public function __construct(AbstractConfigLoader $loader)
	{
		$this->loader = $loader;
	}
}
