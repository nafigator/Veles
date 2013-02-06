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
    const SECONDS      = 1;
    const MILLISECONDS = 2;
    const MICROSECONDS = 3;
    const NANOSECONDS  = 4;

    private static $start_time = 0;
    private static $stop_time  = 0;

    /**
     * Старт таймера
     */
    public static function start()
    {
        self::$start_time = array_sum(explode(' ', microtime()));
    }

    /**
     * Остановка таймера
     */
    public static function stop()
    {
        self::$stop_time = array_sum(explode(' ', microtime()));
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
                return round($diff);
                break;
            case self::MILLISECONDS:
                return round($diff, 3);
                break;
            case self::MICROSECONDS:
                return round($diff, 6);
                break;
            case self::NANOSECONDS:
                return round($diff, 9);
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
