<?php
/**
 * Class for uploaded file validation
 *
 * @file      UploadedFileValidator.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2013-08-03 11:04
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

/**
 * Class UploadedFileValidator
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UploadedFileValidator implements iValidator
{
	/** @var array */
	protected $allowed_extensions = [];

	/**
	 * Creates validator instance
	 *
	 * @param string $ext_string List of valid extension separated by comma
	 */
	public function __construct($ext_string = 'gif,jpg,jpeg,png')
	{
		$extensions = explode(',', $ext_string);

		foreach ($extensions as $extension) {
			$this->allowed_extensions[trim($extension)] = true;
		}
	}

	/**
	 * Uploaded file validation
	 *
	 * @param mixed $value Index name in $_FILE array
	 *
	 * @return bool
	 */
	public function check($value)
	{
		$file_name = strtolower($_FILES[$value]['name']);

		if (false === strpos($file_name, '.')) {
			return false;
		}

		$array    = explode('.', $file_name);
		$file_ext = strtolower(end($array));

		if (!isset($this->allowed_extensions[$file_ext])) {
			return false;
		}

		$real_mime = (new \finfo(FILEINFO_MIME))
			->file($_FILES[$value]['tmp_name']);

		return $real_mime === $this->getMimeByExtension($file_ext);
	}

	/**
	 * Get MIME type for given extension
	 *
	 * @param string $ext File extension
	 *
	 * @return string
	 */
	public function getMimeByExtension($ext)
	{
		$mime_types = [
			'gif'  => 'image/gif; charset=binary',
			'png'  => 'image/png; charset=binary',
			'jpeg' => 'image/jpeg; charset=binary',
			'jpg'  => 'image/jpeg; charset=binary'
		];

		return isset($mime_types[$ext]) ? $mime_types[$ext] : '';
	}
}
