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
	private $dir_mask = 0755;
	private $hash_algorithm = 'sha1';

	/**
	 * Set upload directory mask
	 *
	 * @param int $dir_mask Value must be octal. Examples: 0755, 02755
	 * @return UploadFile
	 */
	final public function setDirMask($dir_mask)
	{
		$this->dir_mask = $dir_mask;

		return $this;
	}

	/**
	 * Det upload directory mask
	 *
	 * @return int
	 */
	final public function getDirMask()
	{
		return $this->dir_mask;
	}

	/**
	 * Get uploaded file origin name
	 *
	 * @return string
	 */
	final public function getOrigName()
	{
		return $this->orig_name;
	}

	/**
	 * Set uploaded file origin name
	 *
	 * @param string $orig_name Origin file name
	 * @return UploadFile
	 */
	final public function setOrigName($orig_name)
	{
		$this->orig_name = $orig_name;

		return $this;
	}

	/**
	 * Generate path for uploaded file
	 */
	final public function initStorageName()
	{
		// initialize storage name only once
		if (null !== $this->getHash()) {
			return;
		}

		$array = explode('.', $this->getOrigName());
		$extension = strtolower(end($array));

		$this->setHash(
			hash_file($this->getHashAlgorithm(), $this->getTmpPath())
		)
			->setSubDir(substr($this->getHash(), 0, 2))
			->setName(substr($this->getHash(), 2) . '.' . $extension)
			->setWwwPath(
				str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->getDir())
				. DIRECTORY_SEPARATOR
				. $this->getSubDir()
				. DIRECTORY_SEPARATOR
				. $this->getName()
			)
			->setPath(
				$this->getDir()
				. DIRECTORY_SEPARATOR
				. $this->getSubDir()
				. DIRECTORY_SEPARATOR
				. $this->getName()
			);
	}

	/**
	 * Get uploaded file name hash
	 *
	 * @return string
	 */
	final public function getHash()
	{
		return $this->hash;
	}

	/**
	 * Set uploaded file name hash
	 *
	 * @param string $hash
	 * @return UploadFile
	 */
	final public function setHash($hash)
	{
		$this->hash = $hash;

		return $this;
	}

	/**
	 * Get uploaded file sub-dir
	 *
	 * @return string
	 */
	final public function getSubDir()
	{
		return $this->sub_dir;
	}

	/**
	 * Set uploaded file sub-dir
	 *
	 * @param string $sub_dir
	 * @return UploadFile
	 */
	final public function setSubDir($sub_dir)
	{
		$this->sub_dir = $sub_dir;

		return $this;
	}

	/**
	 * Save uploaded file
	 *
	 * @return bool
	 */
	final public function save()
	{
		$dir = $this->getDir();

		is_dir($dir) or mkdir($dir, $this->getDirMask(), true);
		is_writable($dir) or chmod($dir, $this->getDirMask());

		return file_exists($this->getPath())
			? true
			: move_uploaded_file($this->getTmpPath(), $this->getPath());
	}

	/**
	 * Get uploaded file temporary path
	 *
	 * @return string
	 */
	final public function getTmpPath()
	{
		return $this->tmp_path;
	}

	/**
	 * Set uploaded file temporary path
	 *
	 * @param string $tmp_path Uploaded file temp path
	 * @return UploadFile
	 */
	final public function setTmpPath($tmp_path)
	{
		$this->tmp_path = $tmp_path;

		return $this;
	}

	/**
	 * Get uploaded file www-path
	 *
	 * @return string
	 */
	final public function getWwwPath()
	{
		return $this->www_path;
	}

	/**
	 * Set uploaded file www-path
	 *
	 * @param string $www_path www-path to file
	 * @return UploadFile
	 */
	final public function setWwwPath($www_path)
	{
		$this->www_path = $www_path;

		return $this;
	}

	/**
	 * Get uploaded file name hashing algorithm
	 *
	 * @see hash_algos()
	 * @return string
	 */
	public function getHashAlgorithm()
	{
		return $this->hash_algorithm;
	}

	/**
	 * Set uploaded file name hashing algorithm
	 *
	 * @param string $hash_algorithm Hash algorithm
	 * @see hash_algos()
	 * @return UploadFile
	 */
	public function setHashAlgorithm($hash_algorithm)
	{
		$this->hash_algorithm = $hash_algorithm;

		return $this;
	}
}
