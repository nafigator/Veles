<?php
/**
 * Class with MVC implementation
 * @file    Application.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Июн 08 18:10:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Application;

use Veles\Auth\UsrAuth;
use Veles\Config;
use Veles\ErrorHandler\ErrBase;
use Veles\Routing\Route;
use Veles\View\View;

/**
 * Class Application
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Application
{
	/**
	 * Application start
	 */
	public static function run()
	{
		self::setPhpSettings();

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

	/**
	 * ErrorHandlers initialisation
	 */
	public static function setErrorHandlers()
	{
		$error = new ErrBase;
		register_shutdown_function(array($error, 'fatal'));
		set_error_handler(array($error, 'usrError'));
		set_exception_handler(array($error, 'exception'));
	}

	/**
	 * Setup PHP settings from config
	 * @param array $keys Макссив php-параметров и их значений
	 */
	final protected static function setPhpSettings($keys = null)
	{
		$config = (null === $keys)
			? Config::getParams('php')
			: $keys;

		if (null === $config) {
			return;
		}

		foreach ($config as $param => $value) {
			if (is_array($value)) {
				self::setPhpSettings($value);
				continue;
			}

			ini_set($param, $value);
		}
	}
}
