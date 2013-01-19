<?php
/**
 * Класс AutoLoader
 * @file    AutoLoader.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 01 10:19:04 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

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
        spl_autoload_register(__NAMESPACE__ . '\AutoLoader::load');
    }

    /**
     * Автолоадер
     * @param string $name
     */
    final public static function load($name)
    {
        $name = str_replace('\\', DIRECTORY_SEPARATOR, $name);

        require "$name.php";
    }
}
