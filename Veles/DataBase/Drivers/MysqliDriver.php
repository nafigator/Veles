<?php
/**
 * MySQLi драйвер для работы с базой.
 * Для использования необходимо в php наличие mysqli расширения.
 * @file    MysqliDriver.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 09 03:25:07 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase\Drivers;

use \Exception,
    \mysqli,
    \MySQLi_Result,
    \Veles\Config,
    \Veles\DataBase\Drivers\iDbDriver;

/**
 * Класс соединения с базой
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class MysqliDriver implements iDbDriver
{
    private static $curr_link = null;
    private static $links     = array();
    private static $errors    = array();

    /**
     * Получение соединения с базой
     * @param string $name Имя сервера
     * @return mysqli
     */
    private static function setLink($name)
    {
        if (!isset(self::$links[$name]))
            self::connect($name);

        self::$curr_link =& self::$links[$name];
    }

    /**
     * Получение соединения с базой
     * @return mysqli
     */
    public static function getLink()
    {
        if (!self::$curr_link instanceof mysqli) {
            self::connect('master');
            self::setLink('master');
        }

        return self::$curr_link;
    }

    /**
     * Соединение с базой.
     *
     * Метод создаёт экземпляр mysqli класса и сохраняет его в self::$curr_link.
     * @param string $name Имя сервера
     * @throws Exception
     */
    private static function connect($name)
    {
        if (null === ($db_params = Config::getParams('db'))) {
            throw new Exception('Не найдены параметры подключения к базе!');
        }

        if (!isset($db_params[$name])) {
            throw new Exception("Не найдены параметры подключения к серверу $name");
        }

        self::$links[$name] = @mysqli_connect(
            $db_params[$name]['host'],
            $db_params[$name]['user'],
            $db_params[$name]['password'],
            $db_params[$name]['base']
        );

        if (!self::$links[$name] instanceof mysqli) {
            throw new Exception("Не удалось подключиться к серверу $name");
        }
    }

    /**
     * Метод для выполнения non-SELECT запросов
     * @param string $sql Sql-запрос
     * @param string $name Имя сервера
     * @return mixed
     */
    final public static function query($sql, $server)
    {
        self::setLink($server);

        $result = mysqli_query(self::$curr_link, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$curr_link, $sql
            );
        }

        return true;
    }

    /**
     * Метод для выполнения SELECT запросов возвращающих значение одного поля
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return mixed
     */
    final public static function getValue($sql, $server)
    {
        self::setLink($server);

        $result = mysqli_query(self::$curr_link, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$curr_link, $sql
            );
        }

        $row = mysqli_fetch_row($result);

        $result->free();

        return isset($row[0]) ? $row[0] : false;
    }

    /**
     * Метод для выполнения SELECT запросов возвращающих значение одной строки таблицы
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return mixed
     */
    final public static function getRow($sql, $server)
    {
        self::setLink($server);

        $result = mysqli_query(self::$curr_link, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$curr_link, $sql
            );
        }

        $return = mysqli_fetch_assoc($result);

        $result->free();

        return $return;
    }

    /**
     * Метод для выполнения SELECT запросов возвращающих значение коллекцию результатов
     * @param string $server Имя сервера
     * @return mixed
     */
    final public static function getRows($sql, $server)
    {
        self::setLink($server);

        $result = mysqli_query(self::$curr_link, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$curr_link, $sql
            );
        }

        $return = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }

        $result->free();

        return $return;
    }

    /**
     * Функция получения LAST_INSERT_ID()
     */
    final public static function getLastInsertId()
    {
        $result = mysqli_insert_id(self::$curr_link);
        if (false === $result) {
            throw new DbException(
                'Не удалось получить LAST_INSERT_ID()', self::$curr_link
            );
        }

        return $result;
    }

    /**
     * Функция получения FOUND_ROWS()
     * Использовать только после запроса с DbPaginator
     */
    final public static function getFoundRows()
    {
        $sql = 'SELECT FOUND_ROWS()';

        $result = mysqli_query(self::$curr_link, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$curr_link, $sql
            );
        }

        $rows = mysqli_fetch_row($result);

        $result->free();

        return $rows[0];
    }

    /**
     * Метод возвращает массив с ошибками
     * @return  array $errors
     */
    final public static function getErrors()
    {
        return self::$errors;
    }
}
