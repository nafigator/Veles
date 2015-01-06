<?php
/**
 * Json View adapter
 *
 * @file    JsonAdapter.php
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
 * Class JsonAdapter
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
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
	protected function __construct()
	{
		$this->setDriver($this);
	}
}
