<?php
/**
 * Base controller for REST API
 *
 * @file      RestApiController.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
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
	 * @throws NotAllowedException
	 */
	public function index()
	{
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				$result = $this->post();
				break;
			case 'GET':
				$result = $this->get();
				break;
			case 'PUT':
				$result = $this->put();
				break;
			case 'DELETE':
				$result = $this->delete();
				break;
			default:
				throw new NotAllowedException($this);
		};

		return $result;
	}

	/**
	 * The method implements functionality of HTTP POST request
	 *
	 * @return array
	 * @throws NotAllowedException
	 */
	public function post()
	{
		throw new NotAllowedException($this);
	}

	/**
	 * The method implements functionality of HTTP GET request
	 *
	 * @return array
	 * @throws NotAllowedException
	 */
	public function get()
	{
		throw new NotAllowedException($this);
	}

	/**
	 * The method implements functionality of HTTP PUT request
	 *
	 * @return array
	 * @throws NotAllowedException
	 */
	public function put()
	{
		throw new NotAllowedException($this);
	}

	/**
	 * The method implements functionality of HTTP DELETE request
	 *
	 * @return array
	 * @throws NotAllowedException
	 */
	public function delete()
	{
		throw new NotAllowedException($this);
	}
}
