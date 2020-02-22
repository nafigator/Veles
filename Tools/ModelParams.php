<?php
/**
 * Class for testing model params
 *
 * @file      ModelParams.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-12-07 17:12
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

use Model\Type;

/**
 * Class   ModelParams
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class ModelParams
{
	public static function getType($type)
	{
		$string_pattern = static::getStringPattern();
		$int_pattern    = '/.*int(?:eger)?\(\d+\).*/i';
		$float_pattern  = static::getFloatPattern();

		switch (1) {
			case preg_match($string_pattern, $type):
				return Type::STRING;
			case preg_match($int_pattern, $type):
				return Type::INT;
			case preg_match($float_pattern, $type):
				return Type::FLOAT;
		}

		throw new \RuntimeException('Unknown data type');
	}

	/**
	 * Getting string pattern
	 *
	 * @return string
	 */
	protected static function getStringPattern()
	{
		return '/(:?(?:var)?char\(\d+\)'
			. '|(?:medium)?text'
			. '|(?:enum).*'
			. '|(?:date)?time(?:stamp)?'
			. '|date'
			. '|bit\(\d+\)'
			. ')/i';
	}

	/**
	 * Getting float pattern
	 *
	 * @return string
	 */
	protected static function getFloatPattern()
	{
		return '/(?:dec(?:imal)?'
			. '|float'
			. '|real'
			. '|double'
			. ')/i';
	}
}
