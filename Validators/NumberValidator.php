<?php
/**
 * Integer values validator
 *
 * @file      NumberValidator.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Вск Ноя 18 12:48:50 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

/**
 * Class NumberValidator
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class NumberValidator implements ValidatorInterface
{
	protected $max;
	protected $min;

	/**
	 * Constructor
	 * @param int $max Max value
	 * @param int $min Min value
	 */
	public function __construct($min = 1, $max = 2147483647)
	{
		$this->min = (int) $min;
		$this->max = (int) $max;
	}

	/**
	 * Integer validation
	 *
	 * @param mixed $value Value
	 *
	 * @return bool
	 */
	public function check($value)
	{
		if (!is_numeric($value)) {
			return false;
		}

		$value = (int) $value;

		return $this->min <= $value && $value <= $this->max;
	}
}
