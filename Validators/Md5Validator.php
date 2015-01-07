<?php
/**
 * @file    Md5Validator.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2015-01-06 15:30
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Class Md5Validator
 * @author  Yancharuk Alexander <alex@itvault.info>
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
	 * @return bool
	 */
	public function check($value)
	{
		return (bool) preg_match($this->pattern, $value);
	}
}
