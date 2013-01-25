<?php
/**
 * Обработка шаблонов regex-роутов
 * @file    RouteRegex.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 10:47:39 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Класс RouteRegex
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class RouteRegex implements iRouteStrategy
{
    /**
     * Переменная содержит массив со значениями регулярных подмасок url
     * @var array
     */
    private static $map = false;

    /**
     * Проверка на соответствие роута шаблону
     * @param string $pattern Шаблон из конфига для сопоставления
     * @param string $url текущий $_SERVER['REQUEST_URI'] без параметров
     * @return bool
     */
    public static function check($pattern, $url)
    {
        $result = (bool) preg_match($pattern, $url, $matches);

        if (isset($matches[1])) {
            unset($matches[0]);

            self::$map = $matches;
        }

        return $result;
    }

    /**
     * Получение url maps
     * @return mixed
     */
    public static function getMap()
    {
        return self::$map;
    }
}
