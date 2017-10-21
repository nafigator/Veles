<?php
/**
 * Class for organize uploads storage
 *
 * @file      UploadFile.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2013-07-27 22:06
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

/**
 * Class UploadFile
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UploadFile extends File
{
	protected $tmp_path;
	protected $hash;
	protected $sub_dir;
	protected $orig_name;
	protected $www_path;
	protected $dir_mask = 0755;
	protected $hash_algorithm = 'sha1';

	/**
	 * Method created for test purpose
	 *
	 * @codeCoverageIgnore
	 *
	 * @param string $filename    File name
	 * @param string $destination Save destination
	 *
	 * @return bool
	 */
	protected function moveUploadedFile($filename, $destination)
	{
		return move_uploaded_file($filename, $destination);
	}

	/**
	 * Set upload directory mask
	 *
	 * @param int $dir_mask Value must be octal. Examples: 0755, 02755
	 *
	 * @return UploadFile
	 */
	public function setDirMask($dir_mask)
	{
		$this->dir_mask = $dir_mask;

		return $this;
	}

	/**
	 * Det upload directory mask
	 *
	 * @return int
	 */
	public function getDirMask()
	{
		return $this->dir_mask;
	}

	/**
	 * Get uploaded file origin name
	 *
	 * @return string
	 */
	public function getOrigName()
	{
		return $this->orig_name;
	}

	/**
	 * Set uploaded file origin name
	 *
	 * @param string $orig_name Origin file name
	 *
	 * @return UploadFile
	 */
	public function setOrigName($orig_name)
	{
		$this->orig_name = $orig_name;

		return $this;
	}

	/**
	 * Generate path for uploaded file
	 */
	public function initStorageName()
	{
		// initialize storage name only once
		if (null !== $this->getHash()) {
			return;
		}

		$array     = explode('.', $this->getOrigName());
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
	public function getHash()
	{
		return $this->hash;
	}

	/**
	 * Set uploaded file name hash
	 *
	 * @param string $hash
	 *
	 * @return UploadFile
	 */
	public function setHash($hash)
	{
		$this->hash = $hash;

		return $this;
	}

	/**
	 * Get uploaded file sub-dir
	 *
	 * @return string
	 */
	public function getSubDir()
	{
		return $this->sub_dir;
	}

	/**
	 * Set uploaded file sub-dir
	 *
	 * @param string $sub_dir
	 *
	 * @return UploadFile
	 */
	public function setSubDir($sub_dir)
	{
		$this->sub_dir = $sub_dir;

		return $this;
	}

	/**
	 * Save uploaded file
	 *
	 * @return bool
	 */
	public function save()
	{
		$dir = $this->getDir();

		is_dir($dir) || mkdir($dir, $this->getDirMask(), true);
		is_writable($dir) || chmod($dir, $this->getDirMask());

		return file_exists($this->getPath())
			? true
			: $this->moveUploadedFile($this->getTmpPath(), $this->getPath());
	}

	/**
	 * Get uploaded file temporary path
	 *
	 * @return string
	 */
	public function getTmpPath()
	{
		return $this->tmp_path;
	}

	/**
	 * Set uploaded file temporary path
	 *
	 * @param string $tmp_path Uploaded file temp path
	 *
	 * @return UploadFile
	 */
	public function setTmpPath($tmp_path)
	{
		$this->tmp_path = $tmp_path;

		return $this;
	}

	/**
	 * Get uploaded file www-path
	 *
	 * @return string
	 */
	public function getWwwPath()
	{
		return $this->www_path;
	}

	/**
	 * Set uploaded file www-path
	 *
	 * @param string $www_path www-path to file
	 *
	 * @return UploadFile
	 */
	public function setWwwPath($www_path)
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
	 *
	 * @see hash_algos()
	 * @return UploadFile
	 */
	public function setHashAlgorithm($hash_algorithm)
	{
		$this->hash_algorithm = $hash_algorithm;

		return $this;
	}
}
