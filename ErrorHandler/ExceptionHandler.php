<?php
/**
 * Class for exception handling
 *
 * @file      ExceptionHandler.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-08-10 06:03
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
		$this->vars = [
			'time'    => $this->getTime(),
			'message' => $exception->getMessage(),
			'file'    => $exception->getFile(),
			'line'    => $exception->getLine(),
			'stack'   => array_reverse($exception->getTrace()),
			'type'    => $exception->getCode(),
			'defined' => ['exception' => $exception]
		];

		$this->notify();
	}
}
