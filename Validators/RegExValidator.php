<?php
/**
 * Regular expression validator
 *
 * @file      RegExValidator.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Авг 14 23:50:04 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Validators;

/**
 * Class RegExValidator
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class RegExValidator implements iValidator
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
