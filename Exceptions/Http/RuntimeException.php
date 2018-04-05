<?php
/**
 * Exception with 500 HTTP code
 *
 * https://tools.ietf.org/html/rfc7231#page-63
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   RuntimeException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class RuntimeException extends HttpResponseException
{
	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 500 Internal Server Error', true, 500);
	}
}
