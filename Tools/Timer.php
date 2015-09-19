<?php
/**
 * Class Timer
 *
 * @file      Timer.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Срд Фев 06 06:18:32 2013
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>.
 */

namespace Veles\Tools;

/**
 * Class Timer
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Timer
{
	// Точность измерения
	const SECONDS      = 0;
	const MILLISECONDS = 3;
	const MICROSECONDS = 6;
	const NANOSECONDS  = 9;
	const PICOSECONDS  = 12;

	private static $start_time = 0;
	private static $stop_time  = 0;
	private static $diff       = 0;

	/**
	 * Timer start
	 */
	public static function start()
	{
		self::$start_time = microtime(true);
	}

	/**
	 * Timer stop
	 */
	public static function stop()
	{
		self::$stop_time = microtime(true);
		self::$diff += self::$stop_time - self::$start_time;
		self::reset(false);
	}

	/**
	 * Get result
	 *
	 * @param int $precision Result precision
	 *
	 * @return mixed
	 */
	public static function get($precision = self::MICROSECONDS)
	{
		switch ($precision) {
			case self::SECONDS:
			case self::MILLISECONDS:
			case self::MICROSECONDS:
			case self::NANOSECONDS:
			case self::PICOSECONDS:
				return round(self::$diff, $precision);
				break;
			default:
				return round(self::$diff, self::MICROSECONDS);
				break;
		}
	}

	/**
	 * Reset internal timer values
	 *
	 * @param bool $full Flag for reset diff value
	 */
	public static function reset($full = true)
	{
		self::$start_time = 0;

		$full and self::$diff = 0;
	}
}
