<?php
/**
 * Interface for validators
 *
 * @file      iValidator.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Авг 14 23:58:56 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Validators;

/**
 * Interface iValidator
 * @author  Alexander Yancharuk <alex at itvault dot info>
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
