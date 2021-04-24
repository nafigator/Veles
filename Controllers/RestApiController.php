<?php
/**
 * Base controller for REST API
 *
 * @file      RestApiController.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-12-07 18:54
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Controllers;

use Veles\Exceptions\Http\NotAllowedException;

/**
 * Class   RestApiController
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class RestApiController extends BaseController
{
	/**
	 * Call specific method depending on request method
	 *
	 * @return array|null
	 */
	public function index(): ?array
	{
		$method = strtolower($_SERVER['REQUEST_METHOD']);

		return $this->$method();
	}

	/**
	 * For not defined methods return 405 response
	 *
	 * @param $name
	 * @param $arguments
	 *
	 * @throws NotAllowedException
	 */
	public function __call($name, $arguments)
	{
		throw new NotAllowedException($this);
	}
}
