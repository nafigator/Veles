<?php
/**
 * Trait for handling Request object
 *
 * @file      RequestTrait.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2017-01-21 17:55
 */

namespace Veles\Application\Traits;

use Veles\Application\Interfaces\ApplicationInterface;
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
	 * @return ApplicationInterface|static
	 */
	public function setRequest(HttpRequestAbstract $request): self
	{
		$this->request = $request;

		return $this;
	}

	/**
	 * Get incoming request object
	 *
	 * @return HttpRequestAbstract
	 */
	public function getRequest(): HttpRequestAbstract
	{
		return $this->request;
	}
}
