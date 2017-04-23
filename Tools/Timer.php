<?php
/**
 * Class Timer
 *
 * @file      Timer.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Срд Фев 06 06:18:32 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tools;

/**
 * Class Timer
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Timer
{
	// Precision
	const SECONDS      = 0;
	const MILLISECONDS = 3;
	const MICROSECONDS = 6;
	const NANOSECONDS  = 9;
	const PICOSECONDS  = 12;

	private static $start_time = 0.0;
	private static $stop_time  = 0.0;
	private static $diff       = 0.0;

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
		self::$start_time = 0.0;
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
			default:
				return round(self::$diff, self::MICROSECONDS);
		}
	}

	/**
	 * Reset internal timer values
	 */
	public static function reset()
	{
		self::$start_time = 0.0;
		self::$diff       = 0.0;
	}
}
