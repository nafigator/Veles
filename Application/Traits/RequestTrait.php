<?php
/**
 * Trait for handling Request object
 *
 * @file      RequestTrait.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2017-01-21 17:55
 */

namespace Veles\Application\Traits;

use Veles\Request\HttpRequestAbstract;

trait RequestTrait
{
	/** @var  HttpRequestAbstract */
	protected $request;

	/**
	 * Set incoming application request
	 *
	 * @param HttpRequestAbstract $request
	 *
	 * @return $this
	 */
	public function setRequest(HttpRequestAbstract $request)
	{
		$this->request = $request;

		return $this;
	}

	/**
	 * Get incoming request object
	 *
	 * @return HttpRequestAbstract
	 */
	public function getRequest()
	{
		return $this->request;
	}
}
