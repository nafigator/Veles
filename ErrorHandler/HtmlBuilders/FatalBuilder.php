<?php
/**
 * Class for building fatal errors in HTML
 *
 * @file    FatalBuilder.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-06-06 20:25
 * @license The BSD 3-Clause License
 *          <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\ErrorHandler\HtmlBuilders;

use Veles\View\View;

/**
 * Class FatalBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class FatalBuilder extends AbstractBuilder
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
