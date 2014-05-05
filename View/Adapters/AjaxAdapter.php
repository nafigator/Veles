<?php
/**
 * Adapter for Ajax-requests
 *
 * @file    AjaxAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Mon May  5 16:46:28 MSK 2014
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;


use Exception;

class AjaxAdapter extends ViewAdapterAbstract implements iViewAdapter
{
	/** @var array */
	private static $variables = array();

	/**
	 * Driver initialization
	 */
	protected function __construct()
	{
		// Just a stub method. Ajax adapter not need additional driver
	}

	/**
	 * Method for output variables setup
	 *
	 * @param array $vars Output variables array
	 * @throws Exception
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
	 * @param array $vars Variables array for cleanup
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
	 */
	public function get($path)
	{
		// Just a stub method
	}

	/**
	 * Check template cache status
	 *
	 * @param string $tpl Template file
	 * @return bool Cache status
	 */
	public function isCached($tpl)
	{
		//TODO implement cache check
		return false;
	}
}
