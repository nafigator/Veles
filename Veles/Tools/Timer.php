<?php
/**
 * Класс-таймер
 * @file    Timer.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Фев 06 06:18:32 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tools;

use \Exception;

/**
 * Класс Timer
 * @author  Yancharuk Alexander <alex@itvault.info>
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
        self::$stop_time = microtime(true);
    }

    /**
     * Получение результата
     * @param int $precision Точность измерения
     * @return mixed
     */
    public static function get($precision = self::MICROSECONDS)
    {
        $diff = self::$stop_time - self::$start_time;

        switch ($precision) {
            case self::SECONDS:
            case self::MILLISECONDS:
            case self::MICROSECONDS:
            case self::NANOSECONDS:
            case self::PICOSECONDS:
                return round($diff, $precision);
                break;
            default:
                return round($diff, self::MICROSECONDS);
                break;
        }
    }

    /**
     * Сброс значений
     */
    public static function reset()
    {
        self::$stop_time  = 0;
        self::$start_time = 0;
    }
}
