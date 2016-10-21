<?php
/**
 * Base class for config loaders
 *
 * @file      AbstractConfigLoader.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault dot info>
 * @date      2015-05-24 11:57
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
