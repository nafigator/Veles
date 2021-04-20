<?php
/**
 * Interface for handling request object
 *
 * @file      RequestAwareInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-02-20 05:08
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application\Interfaces;

use Veles\Request\HttpRequestAbstract;

interface RequestAwareInterface
{
	/**
	 * Set incoming application request
	 *
	 * @param HttpRequestAbstract $request
	 *
	 * @return $this
	 */
	public function setRequest(HttpRequestAbstract $request);

	/**
	 * Get incoming request object
	 *
	 * @return HttpRequestAbstract
	 */
	public function getRequest();
}
