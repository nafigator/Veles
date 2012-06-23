<?php
/**
 * Класс AutoLoader
 * @file    AutoLoader.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 01 10:19:04 2012
 * @version
 */

/**
 * Класс AutoLoader
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class AutoLoader
{
    /**
     * Инициируем автолоадер
     */
    final public static function init()
    {
        spl_autoload_register('AutoLoader::load');
    }

    /**
     * Автолоадер
     * @param string $name
     */
    final public static function load($name)
    {
        $name = str_replace('_', '/', $name);

        require "$name.php";
    }
}
