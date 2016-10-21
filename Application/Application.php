<?php
/**
 * Class with MVC implementation
 *
 * @file      Application.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault dot info>
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

	/**
	 * Application start
	 */
	public function run()
	{
		$controller  = $this->getRoute()->getController($this);
		$action_name = $this->getRoute()->getActionName();

		View::setAdapter($this->getRoute()->getAdapter());
		View::set($controller->$action_name());

		View::show($this->getRoute()->getTemplate());
	}
}
