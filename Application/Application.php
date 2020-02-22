<?php
/**
 * Class with MVC implementation
 *
 * @file      Application.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      Птн Июн 08 18:10:37 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

use Application\Interfaces\EnvironmentAwareInterface;
use Application\Interfaces\RequestAwareInterface;
use Application\Interfaces\RouteAwareInterface;
use Application\Interfaces\VersionAwareInterface;
use Veles\Application\Traits\EnvironmentTrait;
use Veles\Application\Traits\RequestTrait;
use Veles\Application\Traits\RouteTrait;
use Veles\Application\Traits\VersionTrait;
use Veles\View\View;

/**
 * Class Application
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Application implements
	EnvironmentAwareInterface,
	RequestAwareInterface,
	RouteAwareInterface,
	VersionAwareInterface
{
	use RequestTrait;
	use RouteTrait;
	use VersionTrait;
	use EnvironmentTrait;

	/**
	 * Application start
	 *
	 * @throws \Exception
	 */
	public function run()
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
