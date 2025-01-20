<?php
/**
 * Base application interface
 *
 * @file      ApplicationInterface.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2021-04-20 07:07
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application\Interfaces;

use Veles\Request\HttpRequestAbstract;
use Veles\Routing\Route;

interface ApplicationInterface
{
	public function run(): void;

	public function getRoute(): Route;

	public function setRequest(HttpRequestAbstract $request);

	public function getRequest(): HttpRequestAbstract;

	public function setRoute(Route $route);
}
