<?php
/**
 * Default View adapter
 *
 * @file    NativeAdapter.php
 *
 * PHP version 5.4+
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
class NativeAdapter extends ViewAdapterAbstract
{
	/** @var  null|array */
	protected static $calls;
	/** @var $this */
	protected static $instance;
	/** @var string */
	private static $template_dir;

	/**
	 * Set templates directory
	 *
	 * @param string $template_dir
	 */
	public static function setTemplateDir($template_dir)
	{
		self::$template_dir = $template_dir;
	}

	/**
	 * Get templates directory
	 *
	 * @return string
	 */
	public static function getTemplateDir()
	{
		return self::$template_dir;
	}

	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
		foreach ($this->variables as $var_name => $value) {
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
	public function get($path)
	{
		foreach ($this->variables as $var_name => $value) {
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
	public function __construct()
	{
		$this->setDriver($this);
	}
}
