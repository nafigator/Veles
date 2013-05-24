<?php
/**
 * Adapter for Smarty templater
 * @file    SmartyAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    2013-05-18 17:59
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use Exception;
use Smarty;
use Veles\Config;

/**
 * Class SmartyAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class SmartyAdapter implements iViewAdapter
{
	private $smarty;

	private function checkDefaults($conf)
	{
		// TODO: check required smarty settings
		return true;
	}

	final public function __construct()
	{
		require_once 'Smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php';

		if (null === ($conf = Config::getParams('smarty'))) {
			throw new Exception('Not found Smarty params in config!');
		}

		if (!$this->checkDefaults($conf)) {
			throw new Exception('Not found required smarty settings!');
		}

		$this->smarty = new Smarty();

		$this->smarty->setTemplateDir(BASE_PATH . $conf['templates']);
		$this->smarty->setCompileDir(BASE_PATH . $conf['templates_c']);
		$this->smarty->setCacheDir(BASE_PATH . $conf['cache']);
		$this->smarty->setConfigDir(BASE_PATH . $conf['configs']);
	}

	/**
	 * Method for output variables setup
	 *
	 * @param array $vars Output variables array
	 * @throws Exception
	 */
	final public function set($vars)
	{
		if (!is_array($vars)) {
			throw new Exception('View can set variables only in arrays!');
		}

		foreach ($vars as $name => $value) {
			$this->smarty->assign($name, $value);
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
			$this->smarty->clearAssign($name);
		}
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	final public function show($path)
	{
		$this->smarty->display($path);
	}

	/**
	 * Return value of View compilation
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	final public function get($path)
	{
		return $this->smarty->fetch($path);
	}
}
