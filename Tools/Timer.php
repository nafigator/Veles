<?php
/**
 * Класс-таймер
 * @file    Timer.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Срд Фев 06 06:18:32 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tools;

/**
 * Класс Timer
 * @author  Alexander Yancharuk <alex@itvault.info>
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
	private static $diff       = 0;

	/**
	 * Старт таймера
	 */
	public static function start()
	{
		self::$start_time = microtime(true);
	}

	/**
	 * Остановка таймера
	 */
	public static function stop()
	{
		self::$diff += microtime(true) - self::$start_time;
		self::reset(false);
	}

	/**
	 * Получение результата
	 * @param int $precision Точность измерения
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
	 * Сброс значений
	 * @param bool $full Флаг полного сброса значений
	 */
	public static function reset($full = true)
	{
		self::$start_time = 0;

		$full && self::$diff = 0;
	}
}
