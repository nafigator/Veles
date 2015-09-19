<?php
/**
 * Base class for config loaders
 *
 * @file      AbstractConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-05-24 11:57
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Routing;

/**
 * Class AbstractConfigLoader
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
abstract class AbstractConfigLoader
{
	/** @var  string */
	protected $path;

	/**
	 * Create instance and set path to config file
	 *
	 * @param string $path
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}

	/**
	 * Load routes data from file
	 *
	 * return array
	 */
	abstract public function load();

	/**
	 * Get path to config file
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
}
