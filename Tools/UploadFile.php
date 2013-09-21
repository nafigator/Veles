<?php
/**
 * Class for organize uploads storage
 * @file    UploadFile.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-07-27 22:06
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tools;

/**
 * Class UploadFile
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UploadFile extends File
{
	private $tmp_path;
	private $hash;
	private $sub_dir;
	private $orig_name;
	private $www_path;
	private $dir_mask;

	/**
	 * Set upload directory mask
	 *
	 * @param int $dir_mask Value must be octal. Examples: 0755, 02755
	 */
	final public function setDirMask($dir_mask)
	{
		$this->dir_mask = octdec($dir_mask);
	}

	/**
	 * Det upload directory mask
	 * @return mixed
	 */
	final public function getDirMask()
	{
		return $this->dir_mask;
	}

	/**
	 * @return string
	 */
	final public function getOrigName()
	{
		return $this->orig_name;
	}

	/**
	 * @param string $orig_name
	 */
	final public function setOrigName($orig_name)
	{
		$this->orig_name = $orig_name;
	}

	/**
	 * Generate path for uploaded file
	 * @todo Implement adapters for different save algorithms
	 */
	final public function initStorageName()
	{
		// initialize storage name only once
		if (null !== $this->getHash()) {
			return;
		}

		$array = explode('.', $this->getOrigName());
		$extension = strtolower(end($array));

		$this->setHash(hash_file('md5', $this->getTmpPath()));

		$this->setSubDir(substr($this->getHash(), 0, 2));
		$this->setName(substr($this->getHash(), 2) . '.' . $extension);
		$this->setWwwPath(DIRECTORY_SEPARATOR
			. $this->getSubDir()
			. DIRECTORY_SEPARATOR
			. $this->getName()
		);

		$this->setPath($this->getDir()
			. DIRECTORY_SEPARATOR
			. $this->getSubDir()
			. DIRECTORY_SEPARATOR
			. $this->getName()
		);
	}

	/**
	 * @return string
	 */
	final public function getHash()
	{
		return $this->hash;
	}

	/**
	 * @param string $hash
	 */
	final public function setHash($hash)
	{
		$this->hash = $hash;
	}

	/**
	 * @return string
	 */
	final public function getSubDir()
	{
		return $this->sub_dir;
	}

	/**
	 * @param string $sub_dir
	 */
	final public function setSubDir($sub_dir)
	{
		$this->sub_dir = $sub_dir;
	}

	/**
	 * @return bool
	 */
	final public function save()
	{
		$dir = $this->getDir();

		is_dir($dir) or mkdir($dir, $this->getDirMask(), true);
		is_writable($dir) or chmod($dir, 0755);

		return file_exists($this->getPath())
			? true
			: move_uploaded_file($this->getTmpPath(), $this->getPath());
	}

	/**
	 * @return string
	 */
	final public function getTmpPath()
	{
		return $this->tmp_path;
	}

	/**
	 * @param string $tmp_path
	 */
	final public function setTmpPath($tmp_path)
	{
		$this->tmp_path = $tmp_path;
	}

	/**
	 * @return mixed
	 */
	final public function getWwwPath()
	{
		return $this->www_path;
	}

	/**
	 * @param mixed $www_path
	 */
	final public function setWwwPath($www_path)
	{
		$this->www_path = $www_path;
	}
}
