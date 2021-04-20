<?php
/**
 * Exception with 404 code
 *
 * https://tools.ietf.org/html/rfc7231#page-59
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   NotFoundException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class NotFoundException extends HttpResponseException
{
	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 404 Not Found', true, 404);
	}
}
