<?php
/**
 * PHP token validator
 *
 * @file    PhpToken.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Tue Aug 26 18:27:04
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

class PhpToken implements iValidator
{
	/**
	 * PHP token validation
	 *
	 * @param mixed $value Values for checking
	 * @return bool
	 */
	public function check($value)
	{
		if (is_string($value)) {
			return true;
		}

		if (is_array($value)
			&& isset($value[0])
			&& isset($value[1])
			&& isset($value[2])
		) {
			return true;
		}

		return false;
	}
}
