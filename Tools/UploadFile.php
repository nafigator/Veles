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
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UploadFile extends File
{
	private $tmp_path;
	private $hash;
	private $sub_dir;
	private $orig_name;
	private $init_flag;

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
	 */
	final public function initStorageName()
	{
		if (null !== $this->init_flag) {
			return;
		}

		// initialize storage name only once
		$this->init_flag = true;

		$this->setHash(md5(mt_rand()));

		$this->setSubDir(substr($this->getHash(), 0, 2));
		$this->setDir($this->getDir()
			. DIRECTORY_SEPARATOR
			. $this->getSubDir()
		);
		$this->setName(substr($this->getHash(), 2));
		$this->setPath($this->getDir()
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

		//TODO Сделать сеттеры и геттеры для umask директории и файла
		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}

		if (!is_writable($dir)) {
			chmod($dir, 0755);
		}

		return move_uploaded_file($this->getTmpPath(), $this->getPath());
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
}
