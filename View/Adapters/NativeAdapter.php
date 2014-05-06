<?php
/**
 * Default View adapter
 *
 * @file    NativeAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    2013-05-15 22:06
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use Exception;

/**
 * Class NativeAdapter
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class NativeAdapter extends ViewAdapterAbstract implements iViewAdapter
{
	/** @var  null|array */
	protected static $calls;
	/** @var iViewAdapter|$this */
	protected static $instance;
	/** @var array */
	private static $variables = array();
	/** @var string */
	private static $template_dir;

	/**
	 * Set templates directory
	 *
	 * @param string $template_dir
	 */
	final public static function setTemplateDir($template_dir)
	{
		self::$template_dir = $template_dir;
	}

	/**
	 * Get templates directory
	 *
	 * @return string
	 */
	final public static function getTemplateDir()
	{
		return self::$template_dir;
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables or traversable class
	 */
	final public function set($vars)
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
	final public function del($vars)
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
	final public function show($path)
	{
		foreach (self::$variables as $var_name => $value) {
			$$var_name = $value;
		}

		ob_start();
		/** @noinspection PhpIncludeInspection */
		include TEMPLATE_PATH . $path;
		ob_end_flush();
	}

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 * @return string
	 */
	final public function get($path)
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
