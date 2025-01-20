<?php
/**
 * Class for validating MD5 hashes
 *
 * @file      Md5Validator.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-01-06 15:30
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

/**
 * Class Md5Validator
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class Md5Validator implements ValidatorInterface
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
