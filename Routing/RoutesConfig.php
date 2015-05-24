<?php
/**
 * @file    RoutesConfig.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 12:39
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class RoutesConfig
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RoutesConfig implements iRoutesConfig
{
	/** @var  AbstractConfigLoader */
	protected $loader;
	/** @var  array */
	protected $data;

	/**
	 * Returns array that contains routes configuration
	 *
	 * @return array
	 */
	public function getData()
	{
		if (null === $this->data) {
			$this->data = $this->loader->load();
		}

		return $this->data;
	}

	/**
	 * Sets strategy for config loader
	 *
	 * @param AbstractConfigLoader $loader Strategy of loading
	 *
	 * @return $this
	 */
	public function setLoader(AbstractConfigLoader $loader)
	{
		$this->loader = $loader;

		return $this;
	}
}
