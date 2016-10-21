<?php
/**
 * Interface for validators
 *
 * @file      ValidatorInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault dot info>
 * @date      Втр Авг 14 23:58:56 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

/**
 * Interface ValidatorInterface
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface ValidatorInterface
{
	/**
	 * Validation
	 *
	 * @param mixed $value Values for checking
	 * @return bool
	 */
	public function check($value);
}
