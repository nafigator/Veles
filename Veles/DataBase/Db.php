<?php
/**
 * Класс для работы с базой
 * @file    Db.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 06 11:48:07 2013
 * @version
 */

namespace Veles\DataBase;

use \Veles\DataBase\Drivers\iDbDriver,
    \Veles\Config;

/**
 * Класс Db
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Db implements iDbDriver
{
    private static $driver;

    /**
     * Инстанс драйвера
     * @todo вынести код создания класса в отдельную фабрику
     */
    private static function getDriver()
    {
        if (!self::$driver instanceof iDbDriver) {
            if (null === ($class = Config::getParams('dbDriver'))) {
                throw new Exception('Нe указан драйвер для работы с базой!');
            }

            $class_name = "\\Veles\\DataBase\\Drivers\\$class";
            self::$driver = new $class_name;
        }

        return self::$driver;
    }

    /**
     * Метод для получения списка ошибок
     */
    public static function getErrors()
    {
        return self::getDriver()->getErrors();
    }

    /**
     * Функция получения FOUND_ROWS()
     * Использовать только после запроса с DbPaginator
     */
    public static function getFoundRows()
    {
        return self::getDriver()->getFoundRows();
    }

    /**
     * Функция получения LAST_INSERT_ID()
     */
    public static function getLastInsertId()
    {
        return self::getDriver()->getLastInsertId();
    }

    /**
     * Метод для выполнения non-SELECT запросов
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return bool
     */
    public static function query($sql, $server = 'master')
    {
        return self::getDriver()->query($sql, $server);
    }

    /**
     * Метод для выполнения SELECT запросов возвращающих значение одного поля
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return mixed
     */
    public static function getValue($sql, $server = 'master')
    {
        return self::getDriver()->getValue($sql, $server);
    }

    /**
     * Метод для выполнения SELECT запросов возвращающих значение одной строки таблицы
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return array
     */
    public static function getRow($sql, $server = 'master')
    {
        return self::getDriver()->getRow($sql, $server);
    }

    /**
     * Метод для выполнения SELECT запросов возвращающих значение коллекцию результатов
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return array
     */
    public static function getRows($sql, $server = 'master')
    {
        return self::getDriver()->getRows($sql, $server);
    }
}
