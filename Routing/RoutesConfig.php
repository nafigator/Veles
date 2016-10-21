<?php
/**
 * Concrete config class
 *
 * @file      RoutesConfig.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      2015-05-24 12:39
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
