<?php
/**
 * Обработка шаблонов статических роутов
 * @file    RouteStatic.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 10:42:18 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles\Routing;

/**
 * Класс RouteStatic
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class RouteStatic implements iRouteStrategy
{
    /**
     * Проверка на соответствие роута шаблону
     * @param string $pattern
     * @param string $url
     * @return bool
     */
    public static function check($pattern, $url)
    {
        return $pattern === $url;
    }
}