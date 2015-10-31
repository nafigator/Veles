<?php
/**
 * Routing class
 *
 * @file      Route.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Сбт Июн 23 08:52:41 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

use Exception;

/**
 * Class Route
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @TODO Decrease class responsibility by creating separate class for request
 */
class Route extends RouteBase
{
	protected $page_name;
	/** @var  array Current route config */
	protected $config;
	protected $template;
	protected $params = [];

	/**
	 * Config parser and controller vars initialisation
	 *
	 * @throws Exception
	 */
	public function init()
	{
		$routes = $this->getConfigHandler()->getData();
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		foreach ($routes as $name => $route) {
			/** @noinspection PhpUndefinedMethodInspection */
			if (!$route['class']::check($route['route'], $uri)) {
				continue;
			}

			$this->config    = $route;
			$this->page_name = $name;

			if (isset($route['tpl'])) {
				$this->template = $route['tpl'];
			}

			$this->checkAjax();

			if ('Veles\Routing\RouteRegex' === $route['class']) {
				/** @noinspection PhpUndefinedMethodInspection */
				$this->params = $route['class']::getParams();
			}

			break;
		}
		if (null === $this->config && null !== $this->ex404) {
			throw new $this->ex404;
		}

		return $this;
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

		throw new Exception('AJAX-route got non-AJAX request!');
	}

	/**
	 * Getting ajax-flag
	 *
	 * @throws Exception
	 * @return bool
	 */
	public function isAjax()
	{
		return isset($this->config['ajax']) ? true : false;
	}

	/**
	 * Access to controller
	 *
	 * @throws Exception
	 * @return mixed
	 */
	public function getController()
	{
		if (!isset($this->config['controller'])) {
			throw new Exception('Не указан контроллер!');
		}

		$controller = 'Controllers\\' . $this->config['controller'];

		return new $controller;
	}

	/**
	 * Get controller method name
	 *
	 * @throws Exception
	 * @return string
	 */
	public function getActionName()
	{
		if (!isset($this->config['action'])) {
			throw new Exception('Не указан экшен!');
		}

		return $this->config['action'];
	}

	/**
	 * Get View adapter class
	 *
	 * @return \Veles\View\Adapters\ViewAdapterAbstract
	 * @throws \Exception
	 */
	public function getAdapter()
	{
		if (!isset($this->config['view'])) {
			throw new Exception('Не указан адаптер!');
		}

		/** @var \Veles\View\Adapters\ViewAdapterAbstract $adapter_name */
		$adapter_name = $this->config['view'];
		return $adapter_name::instance();
	}

	/**
	 * Getting page name
	 *
	 * @return string
	 */
	public function getPageName()
	{
		return $this->page_name;
	}

	/**
	 * Getting URL-params
	 *
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * Return template path
	 */
	public function getTemplate()
	{
		return $this->template;
	}
}
