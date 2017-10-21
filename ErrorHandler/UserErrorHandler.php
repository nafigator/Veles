<?php
/**
 * Class for user error handling
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\ErrorHandler;

/**
 * Class UserErrorHandler
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UserErrorHandler extends BaseErrorHandler
{
	public function run($type, $message, $file, $line, $defined)
	{
		$this->vars['type']    = $type;
		$this->vars['time']    = $this->getTime();
		$this->vars['message'] = $message;
		$this->vars['file']    = $file;
		$this->vars['line']    = $line;
		$this->vars['stack']   = array_reverse(debug_backtrace());
		$this->vars['defined'] = $defined;

		$this->notify();
	}
}
