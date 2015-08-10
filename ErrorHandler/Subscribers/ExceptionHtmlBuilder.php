<?php
/**
 * @file    ExceptionHtmlBuilder.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-06-06 20:24
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler\Subscribers;

use Veles\View\View;

/**
 * Class ExceptionHtmlBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ExceptionHtmlBuilder extends AbstractErrorHtmlBuilder
{
	/**
	 * @return string
	 */
	public function getHtml()
	{
		$vars = $this->handler->getVars();
		$vars['stack'] = $this->getBacktrace($vars['stack']);
		$vars['type'] = $this->getErrorType($vars['type']);
		View::set($vars);

		return View::get($this->getTemplate());
	}
}
