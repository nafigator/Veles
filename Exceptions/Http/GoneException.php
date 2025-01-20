<?php
/**
 * Exception with 410 error code
 *
 * https://tools.ietf.org/html/rfc7231#page-60
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   GoneException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class GoneException extends HttpResponseException
{
	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 410 Gone', true, 410);
	}
}
