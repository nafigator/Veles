<?php
/**
 * Class for user error handling
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
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
		$this->vars['time']    = strftime(
			'%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']
		);
		$this->vars['message'] = $message;
		$this->vars['file']    = $file;
		$this->vars['line']    = $line;
		$this->vars['stack']   = array_reverse(debug_backtrace());
		$this->vars['defined'] = $defined;

		$this->notify();
	}
}
