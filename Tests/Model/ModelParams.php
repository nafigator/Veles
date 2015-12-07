<?php
/**
 * Class for testing model params
 *
 * @file      ModelParams.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-12-07 17:12
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\Model;

/**
 * Class   ModelParams
 *
 * @author Yancharuk Alexander <ya@zerotech.ru>
 */
class ModelParams
{
	public static function getType($type)
	{
		$result = '';

		if (preg_match('/(?:var)?char\(\d+\)/i', $type)
			or preg_match('/(?:medium)?text/i', $type)
			or preg_match('/(?:enum).*/i', $type)
			or 'timestamp' === $type
		) {
			return 'string';
		} elseif (preg_match('/.*int\(\d+\).*/i', $type)) {
			return 'int';
		}

		return $result;
	}
}
