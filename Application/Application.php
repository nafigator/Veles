<?php
/**
 * Class with MVC implementation
 *
 * @file      Application.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Птн Июн 08 18:10:37 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

use Veles\Auth\UsrAuth;
use Veles\Routing\Route;
use Veles\View\View;

/**
 * Class Application
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Application
{
	/**
	 * Application start
	 */
	public static function run()
	{
		UsrAuth::instance();

		// Get route, controller, method
		$route       = Route::instance();
		$controller  = $route->getController();
		$action_name = $route->getActionName();
		$template    = $route->getTemplate();

		View::setAdapter($route->getAdapter());
		View::set($controller->$action_name());

		View::show($template);
	}
}
