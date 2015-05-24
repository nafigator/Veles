<?php
/**
 * @file    AbstractConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 11:57
 * @copyright The BSD 3-Clause License
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

	/**
	 * Set path to config file
	 *
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}
}
