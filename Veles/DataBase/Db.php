<?php
/**
 * Класс для работы с базой
 * @file    Db.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 06 11:48:07 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use \Veles\DataBase\Drivers\iDbDriver;
use \Veles\DataBase\DbFabric;

/**
 * Класс Db
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Db implements iDbDriver
{
    private static $driver;

    /**
     * Инстанс драйвера
     * @return iDbDriver
     */
    private static function getDriver()
    {
        if (!self::$driver instanceof iDbDriver) {
            self::$driver = DbFabric::getDriver();
        }

        return self::$driver;
    }

    /**
     * Получение текущего линка к базе
     */
    final public static function getLink()
    {
        return self::getDriver()->getLink();
    }

    /**
     * Метод для получения списка ошибок
     */
    final public static function getErrors()
    {
        return self::getDriver()->getErrors();
    }

    /**
     * Функция получения FOUND_ROWS()
     * Использовать только после запроса с DbPaginator
     */
    final public static function getFoundRows()
    {
        return self::getDriver()->getFoundRows();
    }

    /**
     * Функция получения LAST_INSERT_ID()
     * @return int
     */
    final public static function getLastInsertId()
    {
        return self::getDriver()->getLastInsertId();
    }

    /**
     * Метод для выполнения non-SELECT запросов
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return bool
     */
    final public static function query($sql, $server = 'master')
    {
        return self::getDriver()->query($sql, $server);
    }

    /**
     * Для SELECT, возвращающих значение одного поля
     *
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return mixed
     */
    final public static function getValue($sql, $server = 'master')
    {
        return self::getDriver()->getValue($sql, $server);
    }

    /**
     * Для SELECT, возвращающих значение одной строки таблицы
     *
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return array
     */
    final public static function getRow($sql, $server = 'master')
    {
        return self::getDriver()->getRow($sql, $server);
    }

    /**
     * Для SELECT, возвращающих значение коллекцию результатов
     *
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return array
     */
    final public static function getRows($sql, $server = 'master')
    {
        return self::getDriver()->getRows($sql, $server);
    }
}
