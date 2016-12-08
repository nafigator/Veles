<?php
/**
 * Exception with 501 code
 *
 * https://tools.ietf.org/html/rfc7231#page-63
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   NotImplementedException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class NotImplementedException extends HttpResponseException
{
	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 501 Not Implemented', true, 501);
	}
}
