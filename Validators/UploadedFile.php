<?php
/**
 * Class for uploaded file validation
 *
 * @file    UploadedFile.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-08-03 11:04
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Class UploadedFile
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UploadedFile implements iValidator
{
	private $allowable_extensions = [];

	/**
	 * Creates validator instance
	 *
	 * @param string $ext_string List of valid extension separated by comma
	 */
	public function __construct($ext_string = 'gif,jpg,jpeg,png')
	{
		$extensions = explode(',', $ext_string);

		foreach ($extensions as $extension) {
			$this->allowable_extensions[trim($extension)] = true;
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

		$array = explode('.', $file_name);
		$file_ext = strtolower(end($array));

		if (!$this->allowable($file_ext)) {
			return false;
		}

		if (false === ($file_info = finfo_open(FILEINFO_MIME))) {
			return false;
		}

		$real_mime = finfo_file($file_info, $_FILES[$value]['tmp_name']);
		$mime = self::getMimeByExtension($file_ext);

		return $real_mime === $mime;
	}

	/**
	 * Check is given extension valid
	 *
	 * @param string $ext File extension
	 *
	 * @return bool
	 */
	private function allowable($ext)
	{
		return isset($this->allowable_extensions[$ext]);
	}

	/**
	 * Get MIME type for given extension
	 *
	 * @param string $ext File extension
	 *
	 * @return string
	 */
	final static function getMimeByExtension($ext)
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
