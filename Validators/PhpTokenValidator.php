<?php
/**
 * PHP token validator
 *
 * @file      PhpTokenValidator.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      Tue Aug 26 18:27:04
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

class PhpTokenValidator implements ValidatorInterface
{
	/**
	 * PHP token validation
	 *
	 * @param mixed $value Values for checking
	 *
	 * @return bool
	 */
	public function check($value)
	{
		if (is_string($value)
			|| (is_array($value) && isset($value[0], $value[1], $value[2]))
		) {
			return true;
		}


		return false;
	}
}
