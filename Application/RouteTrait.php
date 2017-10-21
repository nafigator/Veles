<?php
/**
 * Trait for handling route set and get methods
 *
 * @file    RouteTrait.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2016-01-15 18:25
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Application;

use Veles\Routing\Route;

trait RouteTrait
{
	/** @var  Route */
	protected $route;

	/**
	 * Set route object
	 *
	 * @param Route $route
	 * @return $this
	 */
	public function setRoute(Route $route)
	{
		$this->route = $route;

		return $this;
	}

	/**
	 * Get route object
	 *
	 * @return Route
	 */
	public function getRoute()
	{
		return $this->route;
	}
}
