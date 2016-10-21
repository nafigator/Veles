<?php
/**
 * Adapter for Smarty
 *
 * @file      SmartyAdapter.php
 *
 * PHP version 5.6+
 * Smarty version 3+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      2013-05-18 17:59
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\View\Adapters;

use Exception;
use /** @noinspection PhpUndefinedClassInspection */ Smarty;

/**
 * Class SmartyAdapter
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class SmartyAdapter extends ViewAdapterAbstract
{
	/** @var  array */
	protected static $calls = [];
	/** @var $this */
	protected static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		/** @noinspection PhpUndefinedClassInspection */
		$this->setDriver(new Smarty);
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables array or traversable class
	 */
	public function set($vars = [])
	{
		foreach ($vars as $name => $value) {
			$this->getDriver()->assign($name, $value);
		}
	}

	/**
	 * Output variables cleanup
	 *
	 * @param array $vars Variables array for cleanup
	 * @throws Exception
	 */
	public function del(array $vars)
	{
		foreach ($vars as $name) {
			$this->getDriver()->clearAssign($name);
		}
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
		$this->getDriver()->display($path);
	}

	/**
	 * Return value of View compilation
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	public function get($path)
	{
		return $this->getDriver()->fetch($path);
	}

	/**
	 * Clear template cache
	 *
	 * @param string $tpl
	 * @return mixed
	 */
	public function clearCache($tpl)
	{
		return $this->getDriver()->clearCache($tpl);
	}

	/**
	 * Clear all template caches
	 *
	 * @param mixed $exp_time
	 * @return mixed
	 */
	public function clearAllCache($exp_time = null)
	{
		return $this->getDriver()->clearAllCache($exp_time);
	}

	/**
	 * Check is template already cached
	 * @param $tpl
	 * @return bool
	 */
	public function isCached($tpl)
	{
		return $this->getDriver()->isCached($tpl);
	}
}
