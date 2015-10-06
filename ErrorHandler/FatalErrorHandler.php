<?php
/**
 * Class for fatal errors handling
 *
 * @file      FatalErrorHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-08-10 06:02
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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