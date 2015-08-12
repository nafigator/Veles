<?php
/**
 * @file      RouteBase.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-05-24 14:01
 * @copyright The BSD 3-Clause License
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
	protected static $ex404 = '\Veles\Routing\Exceptions\NotFoundException';

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
	 * @param string $ex404 Not Found exception class name
	 */
	public static function setEx404($ex404)
	{
		self::$ex404 = $ex404;
	}
}
