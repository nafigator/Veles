<?php
/**
 * Processing HTTP-request with JSON body
 *
 * @file      HttpJsonRequest.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-18 10:20
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request;

use Veles\Exceptions\Http\UnprocessableException;

/**
 * Class   HttpJsonRequest
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class HttpJsonRequest extends HttpRequestAbstract
{
	/**
	 * Getting http-request body
	 *
	 * @return array
	 */
	public function getBody()
	{
		return json_decode(file_get_contents($this->stream));
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
		$schema    = json_decode($definitions);
		$validator = $this->getValidator();

		$validator->check($raw_data, $schema);

		if (!$validator->isValid()) {
			throw new UnprocessableException($validator->getErrors());
		}

		$this->setData((array) $raw_data);
	}
}
