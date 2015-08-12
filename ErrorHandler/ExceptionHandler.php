<?php
/**
 * @file      ExceptionHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-10 06:03
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler;

/**
 * Class ExceptionHandler
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ExceptionHandler extends BaseErrorHandler
{
	public function run(\Exception $exception)
	{
		$this->vars['time']    = strftime(
			'%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']
		);
		$this->vars['message'] = $exception->getMessage();
		$this->vars['file']    = $exception->getFile();
		$this->vars['line']    = $exception->getLine();
		$this->vars['stack']   = array_reverse($exception->getTrace());
		$this->vars['type']    = $exception->getCode();
		$this->vars['defined'] = ['exception' => $exception];

		$this->notify();
	}
}
