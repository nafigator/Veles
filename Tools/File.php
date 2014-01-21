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
	 * Get absolute directory path
	 *
	 * @return string
	 */
	public function getDir()
	{
		return $this->dir;
	}

	/**
	 * Set absolute directory path
	 *
	 * @param string $dir Absolute directory path
	 *
	 * @return $this
	 */
	public function setDir($dir)
	{
		$this->dir = $dir;

		return $this;
	}

	/**
	 * Get MIME type
	 *
	 * @return string
	 */
	public function getMimeType()
	{
		return $this->mime_type;
	}

	/**
	 * Set MIME type
	 *
	 * @param string $mime_type
	 * @return $this;
	 */
	public function setMimeType($mime_type)
	{
		$this->mime_type = $mime_type;

		return $this;
	}

	/**
	 * Get file name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set file name
	 *
	 * @param string $name File name
	 *
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get absolute file path
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Set absolute file path
	 *
	 * @param string $path Absolute path to file
	 *
	 * @return $this
	 */
	public function setPath($path)
	{
		$this->path = $path;

		$name = basename($path);

		$this->setName($name);

		$dir = rtrim(strchr($path, $name, true), DIRECTORY_SEPARATOR);

		$this->setDir($dir);

		return $this;
	}
}
