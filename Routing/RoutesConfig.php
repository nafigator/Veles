<?php
/**
 * @file      RoutesConfig.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-05-24 12:39
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class RoutesConfig
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RoutesConfig extends AbstractRoutesConfig
{
	/** @var  array */
	protected $data;

	/**
	 * Returns array that contains project routes configuration
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
}
