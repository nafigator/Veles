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

use Exception;
use Veles\Routing\Route;
use Veles\View\Adapters\iViewAdapter;
use Veles\View\Adapters\ViewAdapterAbstract;

/**
 * Class View
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class View
{
	/** @var iViewAdapter */
	protected static $adapter;

	/**
	 * Cache adapter initialisation
	 *
	 * @param iViewAdapter $adapter Adapter
	 */
	public static function setAdapter(iViewAdapter $adapter)
	{
		self::$adapter = $adapter;
	}

	/**
	 * Cache adapter instance
	 *
	 * @throws Exception
	 * @return iViewAdapter|ViewAdapterAbstract
	 */
	public static function getAdapter()
	{
		if (self::$adapter instanceof iViewAdapter) {
			return self::$adapter;
		}

		$adapter = Route::instance()->getAdapter();
		self::setAdapter($adapter);

		return $adapter;
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables
	 */
	public static function set($vars)
	{
		self::getAdapter()->set($vars);
	}

	/**
	 * Output variables cleanup
	 *
	 * @param array $vars Variables array for cleanup
	 */
	public static function del($vars)
	{
		self::getAdapter()->del($vars);
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public static function show($path)
	{
		self::getAdapter()->show($path);
	}

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	public static function get($path)
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
