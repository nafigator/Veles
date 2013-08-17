<?php
/**
 * Class for file
 *
 * @file    File.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-07-27 16:15
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tools;

/**
 * Class File
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class File
{
	protected $name;
	protected $path;
	protected $dir;
	protected $mime_type;

	/**
	 * @return string
	 */
	public function getDir()
	{
		return $this->dir;
	}

	/**
	 * @param string $dir
	 */
	public function setDir($dir)
	{
		$this->dir = $dir;
	}

	/**
	 * @return string
	 */
	public function getMimeType()
	{
		return $this->mime_type;
	}

	/**
	 * @param string $mime_type
	 */
	public function setMimeType($mime_type)
	{
		$this->mime_type = $mime_type;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;

		$name = basename($path);

		$this->setName($name);

		$dir = rtrim(strchr($path, $name, true), DIRECTORY_SEPARATOR);

		$this->setDir($dir);
	}
}
