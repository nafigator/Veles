<?php
/**
 * Контроллер для теста Application
 * @file    Home.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Птн Янв 25 05:49:20 2013
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Controllers\Frontend;

use Veles\Routing\Route;

/**
 * Класс Home
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Home
{
	protected $route;

	public function __construct(Route $route)
	{
		$this->setRoute($route);
	}
	/**
	 * Метод вызываемый при запросе /index.html
	 */
	public function index()
	{
		return ['a' => 'Test', 'b' => 'complete', 'c' => 'Hello'];
	}

	/**
	 * Метод вызываемый при запросе /book/5/user/3
	 */
	public function book()
	{
		return [1, 2, 3];
	}

	/**
	 * @return mixed
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @param mixed $route
	 */
	public function setRoute($route)
	{
		$this->route = $route;
	}
}
