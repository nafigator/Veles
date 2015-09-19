<?php
/**
 * Class for validating MD5 hashes
 *
 * @file      Md5Validator.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-01-06 15:30
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Validators;

/**
 * Class Md5Validator
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class Md5Validator implements iValidator
{
	protected $pattern;

	/**
	 * Constructor
	 *
	 * @param bool $case_sensitive Sensitivity flag
	 */
	public function __construct($case_sensitive = false)
	{
		$this->pattern = $case_sensitive
			? '/^[a-f\d]{32}$/'
			: '/^[a-f\d]{32}$/i';
	}

	/**
	 * Md5 hash validation
	 *
	 * @param string $value Value
	 *
	 * @return bool
	 */
	public function check($value)
	{
		return (bool) preg_match($this->pattern, $value);
	}
}
