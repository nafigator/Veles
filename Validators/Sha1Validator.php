<?php
/**
 * @file      Sha1Validator.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-10-08 19:38
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

/**
 * Class   Sha1Validator
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class Sha1Validator
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
			? '/^[a-f\d]{40}$/'
			: '/^[a-f\d]{40}$/i';
	}

	/**
	 * Sha1 hash validation
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
