<?php
/**
 * Integer values validator
 * @file    Number.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Ноя 18 12:48:50 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Class Number
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Number implements iValidator
{
	private $max;
	private $min;

	/**
	 * Constructor
	 * @param int $max Max value
	 * @param int $min Min value
	 */
	final public function __construct($min = 1, $max = 2147483647)
	{
		$this->min = (int) $min;
		$this->max = (int) $max;
	}

	/**
	 * Integer validation
	 * @param mixed $value Value
	 * @return bool
	 */
	final public function check($value)
	{
		if (!is_numeric($value))
			return false;

		$value = (int) $value;

		return $this->min <= $value && $value <= $this->max;
	}
}
