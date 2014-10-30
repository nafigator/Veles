<?php
/**
 * Regular expression validator
 * @file    RegEx.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 14 23:50:04 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Class RegEx
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class RegEx implements iValidator
{
	private $pattern;

	/**
	 * Constructor
	 * @param string $pattern Шаблон для валидации
	 */
	public function __construct($pattern)
	{
		$this->pattern = $pattern;
	}

	/**
	 * Validation
	 * @param mixed $value Value for checking
	 * @return bool
	 */
	public function check($value)
	{
		return (bool) preg_match($this->pattern, $value);
	}

	/**
	 * Validation (static version)
	 * @param string $pattern Pattern for validation
	 * @param mixed $value Value
	 * @return bool
	 */
	public static function validate($pattern, $value)
	{
		return (bool) preg_match($pattern, $value);
	}
}
