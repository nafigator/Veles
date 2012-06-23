<?php
/**
 * Класс роутинга
 * @file    Route.php
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 08:52:41 2012
 * @version
 */

/**
 * Класс Route
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Route
{
    /**
     * Инициализация контроллера
     * @return object
     */
    final public static function getController()
    {
        return new $controller;
    }

    /**
     * Получение имени метода
     * @return string
     */
    final public static function getAction()
    {
        return $action;
    }
}
