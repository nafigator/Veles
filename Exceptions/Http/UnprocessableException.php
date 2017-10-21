<?php
/**
 * Exception with 422 HTTP code and json array with errors
 *
 * https://tools.ietf.org/html/rfc4918#page-78
 *
 * @file      UnprocessableException.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-12-07 17:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

/**
 * Class   UnprocessableException
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class UnprocessableException extends HttpResponseException
{
	/** @var string  */
	protected $http_msg = 'HTTP/1.1 422 Bad Request';
	/** @var int  */
	protected $http_code = 422;

	/**
	 * Throw BadRequestException with proper HTTP code
	 *
	 * @param array $errors
	 */
	public function __construct(array $errors = [])
	{
		parent::__construct();
		header($this->http_msg, true, $this->http_code);

		if ([] === $errors) {
			return;
		}

		$this->showErrors($errors);
	}

	/**
	 * Show errors in response body
	 *
	 * @param array $errors
	 */
	public function showErrors(array $errors)
	{
		header('Content-Type: application/json', true);

		echo json_encode(
			['errors' => $errors],
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		);
	}
}
