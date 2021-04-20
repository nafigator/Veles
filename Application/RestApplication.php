<?php
/**
 * Application class intended for use with RestApiController
 *
 * @file      RestApplication.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2021-04-20 07:03
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

use Application\Interfaces\ApplicationInterface;
use Application\Interfaces\RequestAwareInterface;
use Application\Interfaces\RouteAwareInterface;
use Exception;
use Veles\Application\Traits\RequestTrait;
use Veles\Application\Traits\RouteTrait;
use Veles\View\View;

class RestApplication implements
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

		if ($vars = $controller->setApplication($this)->index()) {
			View::set($vars);
		}

		View::show($route->getTemplate());
	}
}
