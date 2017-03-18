<?php
/**
 * Base exception for HTTP-exceptions
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   HttpResponseException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class HttpResponseException extends \Exception
{
	/**
	 * Do not show error and do not log in to system log errors
	 */
	public function __construct()
	{
		ini_set('display_errors', 0);
		ini_set('log_errors', 0);
		parent::__construct();
	}
}
