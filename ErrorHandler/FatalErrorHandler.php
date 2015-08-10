<?php
/**
 * @file      FatalErrorHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-10 06:02
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler;

/**
 * Class FatalErrorHandler
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class FatalErrorHandler extends BaseErrorHandler
{
	public function run()
	{
		if (null === ($this->vars = error_get_last())) return;

		$this->vars['time']    = strftime(
			'%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']
		);
		$this->vars['stack']   = [];
		$this->vars['defined'] = [];

		$this->notify();
	}
}
