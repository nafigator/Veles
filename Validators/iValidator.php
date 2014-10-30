<?php
/**
 * Interface for validators
 * @file    iValidator.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 14 23:58:56 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Interface iValidator
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
interface iValidator
{
	/**
	 * Validation
	 *
	 * @param mixed $value Values for checking
	 * @return bool
	 */
	public function check($value);
}
