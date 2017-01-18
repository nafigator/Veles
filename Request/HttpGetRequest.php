<?php
/**
 * @file      HttpGetRequest.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-18 10:43
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request;

/**
 * Class   HttpGetRequest
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class HttpGetRequest extends HttpPostRequest
{
	/**
	 * Getting http-request body
	 *
	 * @return array
	 */
	public function getBody()
	{
		return $_GET;
	}
}
