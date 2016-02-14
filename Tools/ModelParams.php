<?php
/**
 * Class for testing model params
 *
 * @file      ModelParams.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-12-07 17:12
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

/**
 * Class   ModelParams
 *
 * @author Yancharuk Alexander <ya@zerotech.ru>
 */
class ModelParams
{
	public static function getType($type)
	{
		$string_pattern = '/(:?(?:var)?char\(\d+\)'
			. '|(?:medium)?text'
			. '|(?:enum).*'
			. '|(?:date)?time(?:stamp)?'
			. '|date'
			. '|bit\(\d+\)'
			. ')/i';
		$int_pattern    = '/.*int(?:eger)?\(\d+\).*/i';
		$float_pattern  = '/(?:dec(?:imal)?'
			. '|float'
			. '|real'
			. '|double'
			. ')/i';

		switch (1) {
			case preg_match($string_pattern, $type):
				$result = 'string';
				break;
			case preg_match($int_pattern, $type):
				$result = 'int';
				break;
			case preg_match($float_pattern, $type):
				$result = 'float';
				break;
			default:
				throw new \RuntimeException('Unknown data type');
		}

		return $result;
	}
}
