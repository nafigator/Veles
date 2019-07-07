<?php
/**
 * Exception with 400 HTTP code and json array with errors
 *
 * https://tools.ietf.org/html/rfc7231#page-58
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk
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
	/** @var string  */
	protected $http_msg = 'HTTP/1.1 400 Bad Request';
	/** @var int  */
	protected $http_code = 400;
}
