<?php
/**
 * Output class
 *
 * @file      View.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      Сбт Июл 07 07:30:30 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\View;

use Exception;
use Veles\View\Adapters\ViewAdapterAbstract;

/**
 * Class View
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class View
{
	/** @var ViewAdapterAbstract */
	protected static $adapter;

	/**
	 * Cache adapter initialisation
	 *
	 * @param ViewAdapterAbstract $adapter Adapter
	 */
	public static function setAdapter(ViewAdapterAbstract $adapter)
	{
		self::$adapter = $adapter;
	}

	/**
	 * Cache adapter instance
	 *
	 * @throws Exception
	 * @return ViewAdapterAbstract
	 */
	public static function getAdapter()
	{
		if (!self::$adapter instanceof ViewAdapterAbstract) {
			throw new Exception('View adapter not set!');
		}

		return self::$adapter;
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
	public static function del(array $vars)
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
	 *
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
	 *
	 * @return bool
	 */
	public static function isCached($tpl)
	{
		return self::getAdapter()->isCached($tpl);
	}
}
