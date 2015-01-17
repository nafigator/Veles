<?php
/**
 * Integer values validator
 * @file    NumberValidator.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Вск Ноя 18 12:48:50 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Class NumberValidator
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class NumberValidator implements iValidator
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
	 * @param mixed $value Value
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
