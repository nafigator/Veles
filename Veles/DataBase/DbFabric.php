<?php
/**
 * Фабрика для создания класса драйвера базы данных
 * @file    DbFabric.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 06 13:02:08 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use \Veles\Config;

/**
 * Класс DbFabric
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class DbFabric
{
    /**
     * Метод для создания класса драйвера базы данных
     */
    final public static function getDriver()
    {
        if (null === ($class = Config::getParams('dbDriver'))) {
            throw new Exception('Нe указан драйвер для работы с базой!');
        }

        $class_name = "\\Veles\\DataBase\\Drivers\\$class";

        return new $class_name;
    }
}
