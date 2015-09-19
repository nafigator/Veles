<?php
/**
 * Class for outputting already build JSON
 *
 * @file      CustomJsonAdapter.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-01-09 21:20
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\View\Adapters;

/**
 * Class CustomJsonAdapter
 *
 * Class intended for output already built JSON string
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class CustomJsonAdapter extends ViewAdapterAbstract
{
	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
		header('Content-Type: application/json');

		if (empty($this->variables)) return;

		echo $this->variables;
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables or traversable class
	 */
	public function set($vars)
	{
		$this->variables = $vars;
	}

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 *
	 * @return string View content
	 */
	public function get($path)
	{
		ob_start();
		/** @noinspection PhpIncludeInspection */
		echo $this->variables;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Check template cache status
	 *
	 * @param string $tpl Template file
	 *
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
