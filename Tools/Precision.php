<?php
/**
 * Precision values container
 *
 * @file      Precision.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-03-05 20:38
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

class Precision
{
	const SECONDS      = 0;
	const MILLISECONDS = 3;
	const MICROSECONDS = 6;
	const NANOSECONDS  = 9;
	const PICOSECONDS  = 12;

	protected $values = [
		self::SECONDS,
		self::MILLISECONDS,
		self::MICROSECONDS,
		self::NANOSECONDS,
		self::PICOSECONDS
	];

	/**
	 * Returns valid precision values
	 *
	 * @return array
	 */
	public function getValues()
	{
		return $this->values;
	}
}
