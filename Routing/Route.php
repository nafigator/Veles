<?php
/**
 * Routing class
 *
 * @file      Route.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
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
		$uri    = $this->getUri();

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
		}

		return $this->execNotFoundHandler();;
	}

	/**
	 * Safe way to get uri
	 *
	 * @return string
	 */
	protected function getUri()
	{
		$uri = parse_url(
			filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH
		);

		return $uri;
	}

	/**
	 * Not found exception handler
	 *
	 * @return $this
	 */
	protected function execNotFoundHandler()
	{
		if (null === $this->config && null !== $this->ex404) {
			throw new $this->ex404;
		}

		return $this;
	}


	/**
	 * Check for request is ajax
	 */
	protected function checkAjax()
	{
		if (!$this->isAjax())
			return;

		$ajax_header = (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH'));

		if ('XMLHttpRequest' === $ajax_header)
			return;

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
	 * @return object
	 */
	public function getController()
	{
		if (!isset($this->config['controller'])) {
			throw new Exception('Controller name not set!');
		}

		$controller = 'Controllers\\' . $this->config['controller'];
		$result     = new $controller($this);

		return $result;
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
			throw new Exception('Action not set!');
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
			throw new Exception('Route adapter not set!');
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
