<?php
/**
 * Validator for Timer precision values
 *
 * @file      TimerPrecisionValidator.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-03-05 20:32
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

use Veles\Tools\Precision;

class TimerPrecisionValidator implements ValidatorInterface
{
	/**
	 * Validation
	 *
	 * @param mixed $value Values for checking
	 *
	 * @return bool
	 */
	public function check($value)
	{
		return in_array($value, (new Precision)->getValues(), true);
	}
}
