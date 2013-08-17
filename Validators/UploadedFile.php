<?php
/**
 * Class for uploaded file validation
 *
 * @file    UploadedFile.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2013-08-03 11:04
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Class UploadedFile
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UploadedFile implements iValidator
{
	/**
	 * Uploaded file validation
	 * @param mixed $value Index name in $_FILE array
	 * @return bool
	 */
	public function check($value)
	{
		return isset($_FILES[$value]);
	}
}
