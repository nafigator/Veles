<?php
/**
 * Base class for controllers
 *
 * @file      BaseController.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2016-10-21 16:43
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Controllers;

use Veles\Application\Interfaces\ApplicationAwareInterface;
use Veles\Application\Traits\ApplicationTrait;

/**
 * Class   BaseController
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class BaseController implements ApplicationAwareInterface
{
	use ApplicationTrait;

	/**
	 * Getting route params
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	protected function getParam(string $name): string
	{
		$params = $this->getApplication()->getRoute()->getParams();

		return $params[$name];
	}

	/**
	 * Getting request data
	 *
	 * @param $definitions
	 *
	 * @return array
	 */
	protected function getData($definitions): array
	{
		return $this->getApplication()->getRequest()->getData($definitions);
	}
}
