<?php
/**
 * Adapter for redirecting requests
 *
 * @file      RedirectAdapter.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2017-02-19 23:16
 */

namespace Veles\View\Adapters;

/**
 * Class   RedirectAdapter
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class RedirectAdapter extends ViewAdapterAbstract
{
	/**
	 * Driver initialization
	 */
	public function __construct()
	{
		$this->setDriver($this);
	}

	/**
	 * Output method
	 *
	 * Controller must return array like: ['URL']
	 *
	 * @param string $path Path to template
	 */
	public function show($path)
	{
		if (empty($this->variables)) {
			return;
		}

		$path = current($this->variables);

		header("Location: $path", true, 302);
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
		return false;
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
}
