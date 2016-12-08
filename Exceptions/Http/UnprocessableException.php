<?php
/**
 * Exception with 422 HTTP code and json array with errors
 *
 * https://tools.ietf.org/html/rfc4918#page-78
 *
 * @file      UnprocessableException.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
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
	/**
	 * Throw BadRequestException with HTTP 422 code
	 *
	 * @param array $errors
	 */
	public function __construct(array $errors = [])
	{
		parent::__construct();
		header('HTTP/1.1 422 Bad Request', true, 422);

		if (!$errors) {
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
		$output['errors'] = $errors;

		echo json_encode(
			$output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		);
	}
}
