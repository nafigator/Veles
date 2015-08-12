<?php
/**
 * @file      NotFoundException.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-12 07:01
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing\Exceptions;

use Veles\Exceptions\HttpResponseException;

/**
 * Class NotFoundException
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class NotFoundException extends HttpResponseException
{
	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 404 Not Found', true, 404);
	}
}
