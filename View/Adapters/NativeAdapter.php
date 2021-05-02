<?php
/**
 * Default View adapter
 *
 * @file      NativeAdapter.php
 *
 * PHP version 7.1+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2013-05-15 22:06
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\View\Adapters;

/**
 * Class NativeAdapter
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class NativeAdapter extends ViewAdapterAbstract
{
	/** @var  array */
	protected static $calls = [];
	/** @var $this */
	protected static $instance;
	/** @var string */
	protected $template_dir;

	/**
	 * Set templates directory
	 *
	 * @param string $template_dir
	 *
	 * @return $this
	 */
	public function setTemplateDir($template_dir)
	{
		$this->template_dir = $template_dir;

		return $this;
	}

	/**
	 * Get templates directory
	 *
	 * @return string
	 */
	public function getTemplateDir()
	{
		return $this->template_dir;
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
		include $this->getTemplateDir() . $path;
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
		include $this->getTemplateDir() . $path;
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
