<?php
/**
 * Processing HTTP-request with POST body
 *
 * @file      HttpPostRequest.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-18 10:34
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request;

use Veles\Exceptions\Http\UnprocessableException;

/**
 * Class   HttpPostRequest
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class HttpPostRequest extends HttpRequestAbstract
{
	/**
	 * Getting http-request body
	 *
	 * @return array
	 */
	public function getBody()
	{
		return $_POST;
	}

	/**
	 * Check input according definitions
	 *
	 * @param mixed $definitions
	 *
	 * @throws UnprocessableException
	 */
	public function check($definitions)
	{
		$raw_data  = $this->getBody();
		$validator = $this->getValidator();

		$validator->check($raw_data, $definitions);

		if (!$validator->isValid()) {
			throw new UnprocessableException($validator->getErrors());
		}

		$this->setData($raw_data);
	}
}
