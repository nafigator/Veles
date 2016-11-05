<?php
/**
 * Class with MVC implementation
 *
 * @file      Application.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      Птн Июн 08 18:10:37 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

use Veles\View\View;

/**
 * Class Application
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Application
{
	use RouteTrait;
	use VersionTrait;
	use EnvironmentTrait;

	/**
	 * Application start
	 */
	public function run()
	{
		$route      = $this->getRoute();
		$controller = $route->getController($this);
		$action     = $route->getActionName();

		View::setAdapter($route->getAdapter());
		View::set($controller->$action());

		View::show($route->getTemplate());
	}
}
