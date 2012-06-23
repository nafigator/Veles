<?php
/**
 * Обработка шаблонов regex-роутов
 * @file    RouteRegex.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 10:47:39 2012
 * @version
 */

namespace Veles\Routing;

/**
 * Класс RouteRegex
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class RouteRegex implements iRouteStrategy
{
    /**
     * Проверка на соответствие роута шаблону
     * @param string $pattern
     * @param string $url
     * @return bool
     */
    public static function check($pattern, $url)
    {
        return (bool) preg_match($pattern, $url);
    }
}
