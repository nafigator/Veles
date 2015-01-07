<?php
/**
 * ByteValidator values validator
 * @file    ByteValidator.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Фев 17 10:48:43 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Validators;

/**
 * Class ByteValidator
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ByteValidator implements iValidator
{

	/**
	 * Check byte values
	 *
	 * @param mixed $size Size in bytes
	 * @return bool
	 */
	public function check($size)
	{
		return is_numeric($size);
	}

	/**
	 * Convert byte values to human readable format
	 *
	 * @param int $size Size in bytes
	 * @param int $precision Precision of returned values
	 * @return string
	 */
	public static function format($size, $precision = 2)
	{
		$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

		$size = max($size, 0);
		$pow = floor(($size ? log($size) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$size /= (1 << (10 * $pow));

		return number_format($size, $precision) . ' ' . $units[$pow];
	}
}
