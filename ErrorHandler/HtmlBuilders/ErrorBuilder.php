<?php
/**
 * Class for building errors in HTML format
 *
 * @file      ErrorBuilder.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-06-06 20:24
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\ErrorHandler\HtmlBuilders;

use Veles\View\View;

/**
 * Class ErrorBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ErrorBuilder extends AbstractBuilder
{
	/**
	 * @return string
	 */
	public function getHtml()
	{
		$vars = $this->handler->getVars();
		$this->formatBacktrace($vars['stack']);
		$this->convertTypeToString($vars['type']);
		View::set($vars);

		return View::get($this->getTemplate());
	}
}
