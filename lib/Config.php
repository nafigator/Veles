<?php
/**
 * Класс-парсер конфигурации проекта
 * @file    Config.php
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 17:28:22 2012
 * @version
 */

/**
 * Класс Config
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Config
{
    private static $data = NULL;

    /**
     * Парсер конфиг файла
     */
    private static function read()
    {
        // Проверяем определены ли пути

        // Парсим конфиг
    }

    /**
     * Получение параметров конфиг-файла
     * @param string $category
     * @param string $param
     */
    final public static function getParams ($category, $param)
    {
        if (NULL === self::$data) {
            self::read();
        }
    }
}
