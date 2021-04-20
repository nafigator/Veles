<?php
/**
 * Base class for routing
 *
 * @file      RouteBase.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-05-24 14:01
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

/**
 * Class RouteBase
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RouteBase
{
	/** @var  AbstractRoutesConfig */
	protected $config_handler;
	/** @var  string */
	protected $ex404 = '\Veles\Routing\Exceptions\NotFoundException';

	/**
	 * @return AbstractRoutesConfig
	 */
	public function getConfigHandler()
	{
		return $this->config_handler;
	}

	/**
	 * @param AbstractRoutesConfig $handler
	 *
	 * @return static
	 */
	public function setConfigHandler(AbstractRoutesConfig $handler)
	{
		$this->config_handler = $handler;

		return $this;
	}

	/**
	 * Set custom 404 exception class name
	 *
	 * @param string $ex404 Not Found exception class name
	 *
	 * @return static
	 */
	public function setNotFoundException($ex404)
	{
		$this->ex404 = $ex404;

		return $this;
	}
}
