<?php
/**
 * Ajax View adapter
 *
 * @file    AjaxAdapter.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Апр 29 22:20:05 MSK 2014
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use Exception;

/**
 * Class AjaxAdapter
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class AjaxAdapter extends ViewAdapterAbstract implements iViewAdapter
{
	/** @var array */
	private static $variables = [];

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables or traversable class
	 */
	public function set($vars)
	{
		foreach ($vars as $prop => $value) {
			self::$variables[$prop] = $value;
		}
	}

	/**
	 * Output variables cleanup
	 *
	 * @param array $vars Array of variables names
	 * @throws Exception
	 */
	public function del($vars)
	{
		if (!is_array($vars)) {
			throw new Exception('View can unset variables only in arrays!');
		}

		foreach ($vars as $var_name) {
			if (isset(self::$variables[$var_name])) {
				unset(self::$variables[$var_name]);
			}
		}
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
		echo json_encode(self::$variables);
	}

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 * @return string
	 */
	public function get($path)
	{
		foreach (self::$variables as $var_name => $value) {
			$$var_name = $value;
		}

		ob_start();
		/** @noinspection PhpIncludeInspection */
		include TEMPLATE_PATH . $path;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Check template cache status
	 *
	 * @param string $tpl Template file
	 * @return bool Cache status
	 */
	public function isCached($tpl)
	{
		return false;
	}

	/**
	 * Driver initialization
	 */
	protected function __construct()
	{
		$this->setDriver($this);
	}
}
