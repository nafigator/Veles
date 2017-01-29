<?php
/**
 * Processing HTTP-request with JSON body
 *
 * This class intended for use with PhpFilters validator
 *
 * @file      HttpJsonRequest.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2017-01-29 21:21
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
		return json_decode(file_get_contents($this->stream), true);
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
