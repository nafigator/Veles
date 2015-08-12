<?php
/**
 * @file      HttpResponseException.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-12 07:06
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Exceptions;

/**
 * Class HttpResponseException
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class HttpResponseException extends \LogicException
{
	public function __construct()
	{
		ini_set('display_errors', 0);
		ini_set('log_errors', 0);
		parent::__construct();
	}
}
