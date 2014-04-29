<?php
/**
 * Routing class
 * @file    Route.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Сбт Июн 23 08:52:41 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

use Exception;
use Veles\Config;

/**
 * Class Route
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Route
{
	private $page_name = null;
	private $config    = null;
	private $template  = null;
	private $map       = array();

	/**
	 * Config parser and controller vars initialisation
	 * @throws Exception
	 */
	private function __construct()
	{
		if (null === ($routes = Config::getParams('routes'))) {
			throw new Exception('В конфиге не найдены роуты!');
		}

		$q_pos = strpos($_SERVER['REQUEST_URI'], '?');

		$url = ($q_pos)
			? urldecode(substr($_SERVER['REQUEST_URI'], 0, $q_pos))
			: urldecode($_SERVER['REQUEST_URI']);

		foreach ($routes as $name => $route) {
			/** @noinspection PhpUndefinedMethodInspection */
			if (!$route['class']::check($route['route'], $url)) {
				continue;
			}

			$this->config    = $route;
			$this->page_name = $name;

			if (isset($route['tpl'])) {
				$this->template = $route['tpl'];
			}

			$this->checkAjax();

			/** @noinspection PhpUndefinedMethodInspection */
			if (isset($route['map'])
				&& null !== ($map = $route['class']::getMap())
			) {
				$this->map = array_combine($route['map'], $map);
			}

			return;
		}

		Route404::show($url);
	}

	/**
	 * Check for request is ajax
	 */
	private function checkAjax()
	{
		if (!$this->isAjax()) {
			return;
		}

		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH']
		) {
			return;
		}

		throw new Exception('На AJAX-роут отправлен не ajax-запрос!');
	}

	/**
	 * Getting ajax-flag
	 * @throws Exception
	 * @return string
	 */
	final public function isAjax()
	{
		return isset($this->config['ajax']) ? $this->config['ajax'] : false;
	}

	/**
	 * Access to object
	 * @return Route
	 */
	final public static function instance()
	{
		static $instance;

		if (null === $instance) {
			$instance = new Route;
		}

		return $instance;
	}

	/**
	 * Access to controller
	 * @throws Exception
	 * @return object
	 */
	final public function getController()
	{
		if (!isset($this->config['controller'])) {
			throw new Exception('Не указан контроллер!');
		}

		$controller = 'Controllers\\' . $this->config['controller'];

		return new $controller;
	}

	/**
	 * Get controller method name
	 * @throws Exception
	 * @return string
	 */
	final public function getActionName()
	{
		if (!isset($this->config['action'])) {
			throw new Exception('Не указан экшен!');
		}

		return $this->config['action'];
	}

	/**
	 * Get View adapter class
	 *
	 * @return \Veles\View\Adapters\iViewAdapter
	 * @throws \Exception
	 */
	final public function getAdapter()
	{
		if (!isset($this->config['adapter'])) {
			throw new Exception('Не указан адаптер!');
		}

		/** @var \Veles\View\Adapters\ViewAdapterAbstract $adapter_name */
		$adapter_name = $this->config['adapter'];
		return $adapter_name::instance();
	}

	/**
	 * Getting page name
	 * @throws Exception
	 * @return string
	 */
	final public function getPageName()
	{
		if (!isset($this->page_name)) {
			throw new Exception('Не найдено имя страницы!');
		}

		return $this->page_name;
	}

	/**
	 * Getting URL-params
	 * @return array
	 */
	final public function getMap()
	{
		return $this->map;
	}

	/**
	 * Return template path
	 */
	final public function getTemplate()
	{
		return $this->template;
	}
}
