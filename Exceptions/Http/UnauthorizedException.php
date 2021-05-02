<?php
/**
 * Exception with 401 HTTP code
 *
 * https://tools.ietf.org/html/rfc7235#page-6
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   UnauthorizedException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class UnauthorizedException extends HttpResponseException
{
	protected $realm = 'Application Name';
	protected $type  = 'Basic';

	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 401 Unauthorized', true, 401);
		header("WWW-Authenticate: $this->type realm=\"$this->realm\"");
	}
}
