<?php
/**
 * Adapter for Smarty
 *
 * @file    SmartyAdapter.php
 *
 * PHP version 5.3.9+
 * Smarty version 3+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    2013-05-18 17:59
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use Exception;
use Smarty;
use Veles\Config;
use Veles\View\Adapters\ViewAdapterAbstract;

/**
 * Class SmartyAdapter
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class SmartyAdapter extends ViewAdapterAbstract implements iViewAdapter
{
	/**
	 * Constructor
	 */
	final public function __construct()
	{
		include 'Smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php';

		$this->setDriver(new Smarty);
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables array or traversable class
	 * @throws Exception
	 */
	final public function set($vars)
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
	final public function del($vars)
	{
		if (!is_array($vars)) {
			throw new Exception('View can unset variables only in arrays!');
		}

		foreach ($vars as $name) {
			$this->getDriver()->clearAssign($name);
		}
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	final public function show($path)
	{
		$this->getDriver()->display($path);
	}

	/**
	 * Return value of View compilation
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	final public function get($path)
	{
		return $this->getDriver()->fetch($path);
	}

	/**
	 * Clear template cache
	 *
	 * @param string $tpl
	 * @return mixed
	 */
	final public function clearCache($tpl)
	{
		return $this->getDriver()->clearCache($tpl);
	}

	/**
	 * Clear all template caches
	 *
	 * @param mixed $exp_time
	 * @return mixed
	 */
	final public function clearAllCache($exp_time = null)
	{
		return $this->getDriver()->clearAllCache($exp_time);
	}

	/**
	 * Check is template already cached
	 * @param $tpl
	 * @return bool
	 */
	final public function isCached($tpl)
	{
		return $this->getDriver()->isCached($tpl);
	}
}
