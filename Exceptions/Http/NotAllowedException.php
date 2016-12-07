<?php
/**
 * Exception with 405 HTTP code
 *
 * https://tools.ietf.org/html/rfc7231#page-59
 *
 * @file      UserErrorHandler.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      2015-08-11 21:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Exceptions\Http;

use ReflectionClass;
use Veles\Controllers\BaseController;

/**
 * Class   NotAllowedException
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class NotAllowedException extends HttpResponseException
{
	protected $allowed = [
		'get'    => true,
		'post'   => true,
		'put'    => true,
		'delete' => true
	];

	/**
	 * Throw exception with 405 HTTP-code
	 *
	 * According standard http-response "Not Allowed" MUST contain "Allowed"
	 * header with available http-methods
	 *
	 * @param BaseController $controller
	 *
	 * @TODO implement base api contorller
	 */
	public function __construct(BaseController $controller)
	{
		parent::__construct();
		header('HTTP/1.1 405 Method Not Allowed', true, 405);

		$methods = $this->getMethods($controller);

		if ('' !== $methods) {
			header("Allowed: $methods", true);
		}
	}

	/**
	 * Get list of allowed HTTP-methods
	 *
	 * @param BaseController $class
	 *
	 * @return string
	 */
	protected function getMethods(BaseController $class)
	{
		$reflection = new ReflectionClass($class);

		$methods = [];
		foreach ($reflection->getMethods() as $value) {
			if ($value->class !== get_class($class)) {
				continue;
			}

			if (isset($this->allowed[$value->name])) {
				$methods[] = $value->name;
			}
		}

		return strtoupper(implode(', ', $methods));
	}
}
