<?php
/**
 * Regular expression validator
 *
 * @file      RegExValidator.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Втр Авг 14 23:50:04 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Validators;

/**
 * Class RegExValidator
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class RegExValidator implements ValidatorInterface
{
	protected $pattern;

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
	 *
	 * @param mixed $value Value for checking
	 *
	 * @return bool
	 */
	public function check($value)
	{
		return (bool) preg_match($this->pattern, $value);
	}

	/**
	 * Validation (static version)
	 *
	 * @param string $pattern Pattern for validation
	 * @param mixed  $value   Value
	 *
	 * @return bool
	 */
	public static function validate($pattern, $value)
	{
		return (bool) preg_match($pattern, $value);
	}
}
