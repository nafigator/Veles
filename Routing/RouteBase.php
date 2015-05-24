<?php
/**
 * @file    RouteBase.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 14:01
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class RouteBase
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class RouteBase
{
	/** @var  iRoutesConfig */
	protected static $config_handler;

	/**
	 *
	 * @return iRoutesConfig
	 */
	public static function getConfigHandler()
	{
		return self::$config_handler;
	}

	/**
	 * @param iRoutesConfig $config_handler
	 *
	 * @return $this
	 */
	public static function setConfigHandler($config_handler)
	{
		self::$config_handler = $config_handler;
	}
}
