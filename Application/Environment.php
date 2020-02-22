<?php
/**
 * Class for handling environment staff
 *
 * @file      Environment.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-11-05 09:59
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Application;

/**
 * Class   Environment
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class Environment
{
	/** @var  string */
	protected $static_path;
	/** @var  string */
	protected $name;

	/**
	 * Set path to static files for different environments
	 *
	 * @param string $static_path
	 *
	 * @return Environment
	 */
	public function setStaticPath($static_path)
	{
		$this->static_path = $static_path;

		return $this;
	}

	/**
	 * Get path to static files for current environment
	 *
	 * @return string
	 */
	public function getStaticPath()
	{
		return $this->static_path;
	}

	/**
	 * Set environment name
	 *
	 * @param string $name
	 *
	 * @return Environment
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get environment name
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}
}
