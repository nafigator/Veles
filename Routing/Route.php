<?php
/**
 * Routing class
 *
 * @file      Route.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Сбт Июн 23 08:52:41 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

use Exception;
use Veles\Application\Application;
use Veles\Request\HttpRequestAbstract;
use Veles\Request\Validator\Validator;
use Veles\Request\Validator\ValidatorInterface;

/**
 * Class Route
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @TODO Decrease class responsibility by creating separate class for request
 */
class Route extends RouteBase
{
	protected $name;
	/** @var  array Current route config */
	protected $config;
	protected $template;
	protected $params = [];
	/** @var  ValidatorInterface */
	protected $validator;
	/** @var  HttpRequestAbstract */
	protected $request;

	/**
	 * Config parser and controller vars initialisation
	 *
	 * @throws Exception
	 */
	public function init()
	{
		list($uri, $section) = $this->parseUri();
		$routes = $this->getConfigHandler()->getSection($section);

		foreach ($routes as $name => $route) {
			/** @noinspection PhpUndefinedMethodInspection */
			if (!$route['class']::check($route['route'], $uri)) {
				continue;
			}

			$this->config = $route;
			$this->name   = $name;

			if (isset($route['tpl'])) {
				$this->template = $route['tpl'];
			}

			if ('Veles\Routing\RouteRegex' === $route['class']) {
				/** @noinspection PhpUndefinedMethodInspection */
				$this->params = $route['class']::getParams();
			}
		}

		return $this->execNotFoundHandler();
	}

	/**
	 * Safe way to get uri
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	protected function parseUri()
	{
		$uri = parse_url(
			filter_input(INPUT_SERVER, 'REQUEST_URI'), PHP_URL_PATH
		);

		$parts   = explode('/', $uri);
		$section = isset($parts[2]) ? $parts[1] : '';

		return [$uri, $section];
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
	 * Build and return controller object
	 *
	 * @param Application $application
	 *
	 * @return object
	 * @throws Exception
	 */
	public function getController(Application $application)
	{
		if (!isset($this->config['controller'])) {
			throw new Exception('Controller name not set!');
		}

		$controller = 'Controllers\\' . $this->config['controller'];

		return new $controller($application);
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
	 * Getting route name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
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
