<?php
/**
 * Output class
 * @file    View.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Сбт Июл 07 07:30:30 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View;

use Veles\View\Adapters\iViewAdapter;
use Veles\View\Adapters\ViewAdapterAbstract;
use Exception;

/**
 * Class View
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class View
{
	/** @var iViewAdapter */
	private static $adapter;
	/** @var  string|ViewAdapterAbstract */
	private static $adapter_name;

	/**
	 * Cache adapter initialisation
	 *
	 * @param string $class_name Adapter name
	 */
	final public static function setAdapter($class_name = 'Native')
	{
		self::$adapter_name = "\\Veles\\View\\Adapters\\${class_name}Adapter";
		self::$adapter = null;
	}

	/**
	 * Cache adapter instance
	 *
	 * @throws Exception
	 * @return iViewAdapter|ViewAdapterAbstract
	 */
	private static function getAdapter()
	{
		if (self::$adapter instanceof iViewAdapter) {
			return self::$adapter;
		}

		if (null === self::$adapter_name) {
			throw new Exception('Adapter not set!');
		}

		$tmp =& self::$adapter_name;
		self::$adapter = $tmp::instance();

		return self::$adapter;
	}

	/**
	 * Method for output variables setup
	 *
	 * @param array $vars Output variables array
	 */
	final public static function set($vars)
	{
		self::getAdapter()->set($vars);
	}

	/**
	 * Output variables cleanup
	 *
	 * @param array $vars Variables array for cleanup
	 */
	final public static function del($vars)
	{
		self::getAdapter()->del($vars);
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	final public static function show($path)
	{
		self::getAdapter()->show($path);
	}

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	final public static function get($path)
	{
		return self::getAdapter()->get($path);
	}

	/**
	 * Check template cache status
	 *
	 * @param $tpl
	 * @return bool
	 */
	public static function isCached($tpl)
	{
		return self::getAdapter()->isCached($tpl);
	}
}
