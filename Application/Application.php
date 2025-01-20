<?php
/**
 * Class with MVC implementation
 *
 * @file      Application.php
 *
 * PHP version 8.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      Птн Июн 08 18:10:37 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

use Veles\Application\Interfaces\ApplicationInterface;
use Veles\Application\Interfaces\RequestAwareInterface;
use Veles\Application\Interfaces\RouteAwareInterface;
use Exception;
use Veles\Application\Traits\RequestTrait;
use Veles\Application\Traits\RouteTrait;
use Veles\View\View;

/**
 * Class Application
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Application implements
	ApplicationInterface,
	RequestAwareInterface,
	RouteAwareInterface
{
	use RequestTrait;
	use RouteTrait;

	/**
	 * Application start
	 *
	 * @throws Exception
	 */
	public function run(): void
	{
		$route      = $this->getRoute();
		$controller = $route->getController();
		$action     = $route->getActionName();

		if ($vars = $controller->setApplication($this)->$action()) {
			View::set($vars);
		}

		View::show($route->getTemplate());
	}
}
