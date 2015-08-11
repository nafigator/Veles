<?php
/**
 * @file    FatalErrorHtmlBuilder.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-06-06 20:25
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler\HtmlBuilders;

use Veles\View\View;

/**
 * Class FatalErrorHtmlBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class FatalErrorHtmlBuilder  extends AbstractErrorHtmlBuilder
{
	/**
	 * @return string
	 */
	public function getHtml()
	{
		$vars = $this->handler->getVars();
		$vars['type'] = $this->getErrorType($vars['type']);
		View::set($vars);

		return View::get($this->getTemplate());
	}
}
