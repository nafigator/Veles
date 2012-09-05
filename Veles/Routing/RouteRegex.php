<?php
/**
 * Обработка шаблонов regex-роутов
 * @file    RouteRegex.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 10:47:39 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
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
     * @param string $pattern Шаблон из конфига для сопоставления
     * @param string $url текущий $_SERVER['REQUEST_URI'] без параметров
     * @return bool
     */
    public static function check($pattern, $url)
    {
        return (bool) preg_match($pattern, $url);
    }
}
