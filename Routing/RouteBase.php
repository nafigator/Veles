<?php
/**
 * Base class for routing
 *
 * @file      RouteBase.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
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
	protected static $config_handler;
	/** @var  string */
	protected static $_404 = '\Veles\Routing\Exceptions\NotFoundException';

	/**
	 * @return AbstractRoutesConfig
	 */
	public static function getConfigHandler()
	{
		return self::$config_handler;
	}

	/**
	 * @param AbstractRoutesConfig $handler
	 */
	public static function setConfigHandler(AbstractRoutesConfig $handler)
	{
		self::$config_handler = $handler;
	}

	/**
	 * Set custom 404 exception class name
	 *
	 * @param string $_404 Not Found exception class name
	 */
	public static function setNotFoundException($_404)
	{
		self::$_404 = $_404;
	}
}
