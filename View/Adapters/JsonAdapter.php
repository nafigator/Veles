<?php
/**
 * Json View adapter
 *
 * @file      JsonAdapter.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Апр 29 22:20:05 MSK 2014
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\View\Adapters;

/**
 * Class JsonAdapter
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class JsonAdapter extends ViewAdapterAbstract
{
	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
		if (empty($this->variables)) return;

		header('Content-Type: application/json');

		echo json_encode($this->variables);
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
		foreach ($this->variables as $var_name => $value) {
			$$var_name = $value;
		}

		ob_start();
		echo json_encode($this->variables);
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
	public function __construct()
	{
		$this->setDriver($this);
	}
}
