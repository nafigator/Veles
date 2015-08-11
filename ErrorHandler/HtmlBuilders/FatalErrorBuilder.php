<?php
/**
 * @file    FatalErrorBuilder.php
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
 * Class FatalErrorBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class FatalErrorBuilder  extends AbstractBuilder
{
	/**
	 * @return string
	 */
	public function getHtml()
	{
		$vars = $this->handler->getVars();
		$this->convertTypeToString($vars['type']);
		View::set($vars);

		return View::get($this->getTemplate());
	}
}
