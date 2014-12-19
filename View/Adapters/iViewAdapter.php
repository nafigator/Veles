<?php
/**
 * Interface for View adapters
 *
 * @file    iViewDriver.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    2013-05-15 22:01
 * @copyright The BSD 3-Clause License
 */

namespace Veles\View\Adapters;

use Exception;

/**
 * Interface iViewAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
interface iViewAdapter
{
	/**
	 * Output method
	 *
	 * @param string $path Path to template
	 */
	public function show($path);

	/**
	 * Output View into buffer and save it in variable
	 *
	 * @param string $path Path to template
	 * @return string View content
	 */
	public function get($path);

	/**
	 * Check template cache status
	 *
	 * @param string $tpl Template file
	 * @return bool Cache status
	 */
	public function isCached($tpl);
}
