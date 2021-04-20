<?php
/**
 * Interface for handling route object
 *
 * @file      RouteAwareInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-02-20 05:10
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application\Interfaces;

use Veles\Routing\Route;

interface RouteAwareInterface
{
	/**
	 * Set route object
	 *
	 * @param Route $route
	 * @return $this
	 */
	public function setRoute(Route $route);

	/**
	 * Get route object
	 *
	 * @return Route
	 */
	public function getRoute();
}
