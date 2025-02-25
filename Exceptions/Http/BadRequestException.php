<?php
/**
 * Exception with 400 HTTP code and json array with errors
 *
 * https://tools.ietf.org/html/rfc7231#page-58
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-08-12 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   BadRequestException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class BadRequestException extends UnprocessableException
{
	protected $http_msg = 'HTTP/1.1 400 Bad Request';
	protected $http_code = 400;
	protected $message = 'Bad request';
}
