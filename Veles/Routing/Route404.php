<?php
/**
 * Вывод ошибки 404
 * @file    Route404.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Пнд Янв 28 21:20:19 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Routing;

use \Veles\View;

/**
 * Класс Route404
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Route404
{
    /**
     * Вывод 404 ошибки
     * @param string $url URL ошибки
     */
    final public static function show($url)
    {
        header('HTTP/1.1 404 Not Found', true, 404);
        View::set(array('url' => $url));
        die(View::get('error/404.phtml'));
    }
}
