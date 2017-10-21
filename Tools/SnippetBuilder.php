<?php
/**
 * Class for building snippets from external templates
 *
 * @file      SnippetBuilder.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-08-17 17:32
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

/**
 * Class SnippetBuilder
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class SnippetBuilder
{
	protected $variables = [];

	public function __construct($vars)
	{
		foreach ($vars as $var_name => $value) {
			$this->variables[$var_name] = $value;
		}
	}

	/**
	 * Build html using variables and given template
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public function build($path)
	{
		foreach ($this->variables as $var_name => $value) {
			$$var_name = $value;
		}

		ob_start();
		/** @noinspection PhpIncludeInspection */
		include $path;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
