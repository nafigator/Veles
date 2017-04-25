<?php
/**
 * HTTP request object factory
 *
 * This factory should be used in index.php for request object initialization.
 * Example:
 *
 * $validator = (new Validator)->setAdapter(new PhpFilters);
 * $request = RequestFactory::create($_SERVER['CONTENT_TYPE'])->setValidator($validator);
 *
 * @file      RequestFactory.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-04-23 16:12
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request;

class RequestFactory
{
	/**
	 * Create HTTP-request object depending on Content-type HTTP-header
	 *
	 * @param string $type Value of Content-type HTTP-header
	 *
	 * @return HttpRequestAbstract
	 */
	public static function create($type)
	{
		if (empty($type) || 0 === strpos($type, 'text/html')) {
			return new HttpGetRequest;
		}

		return new HttpPostRequest;
	}
}
