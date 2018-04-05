<?php
/**
 * Class for outputting already build JSON
 *
 * @file      CustomJsonAdapter.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      2015-01-09 21:20
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
		if (empty($this->variables)) {
			return;
		}

		header('Content-Type: application/json');

		echo $this->variables;
	}

	/**
	 * Method for output variables setup
	 *
	 * @param mixed $vars Output variables or traversable class
	 */
	public function set($vars = [])
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
		return $this->variables;
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
	public function __construct()
	{
		$this->setDriver($this);
	}
}
