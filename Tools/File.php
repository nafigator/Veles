<?php
/**
 * Class for file
 *
 * @file      File.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk
 * @date      2013-07-27 16:15
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

/**
 * Class File
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class File
{
	protected $name;
	protected $path;
	protected $dir;
	protected $mime;

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
	public function getMime()
	{
		return $this->mime;
	}

	/**
	 * Set MIME type
	 *
	 * @param string $mime
	 * @return $this
	 */
	public function setMime($mime)
	{
		$this->mime = $mime;

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

		$dir = rtrim(strstr($path, $name, true), DIRECTORY_SEPARATOR);

		$this->setDir($dir);

		return $this;
	}

	/**
	 * Delete file
	 *
	 * @return bool
	 */
	public function delete()
	{
		if (!file_exists($this->getPath()) || !is_writable($this->getPath())) {
			return false;
		}

		return unlink($this->getPath());
	}

	/**
	 * Delete file dir if empty
	 *
	 * @return bool
	 */
	public function deleteDir()
	{
		$files = glob($this->getDir() . '/*');

		foreach ($files as $file) {
			if ($file !== $this->getPath()) {
				return false;
			}
		}

		if (!$this->delete()) {
			return false;
		}

		return rmdir($this->getDir());
	}
}
