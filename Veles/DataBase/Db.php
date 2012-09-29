<?php
/**
 * Класс соединения с базой.
 * Для использования необходимо в php наличие mysqli расширения.
 * @file    Db.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 09 03:25:07 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles\DataBase;

use \Exception,
    \mysqli,
    \MySQLi_Result,
    \Veles\Config;

/**
 * Класс соединения с базой
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Db {
    private static $db;
    private static $errors = array();

    /**
     * Соединение с базой.
     * Метод создаёт экземпляр mysqli класса и сохраняет его в self::$db.
     * Нечто наподобие классического синглтона.
     * @throws Exception
     */
    private static function connect()
    {
        if (null === ($db_params = Config::getParams('db'))) {
            throw new Exception('Не найдены параметры подключения к базе!');
        }

        self::$db = @mysqli_connect(
            $db_params['host'],
            $db_params['user'],
            $db_params['password'],
            $db_params['base']
        );

        if (!self::$db instanceof mysqli) {
            throw new Exception('Не удалось подключиться к mysql');
        }
    }

    /**
     * Метод для выполнения запросов
     * @param string $sql Sql-запрос
     * @param bool $list Флаг возврата значений в массиве
     * @return bool Если запрос выполенен без ошибок, возвращает true
     */
    final public static function q($sql, $list = false)
    {
        if (!self::$db instanceof mysqli)
            self::connect();

        $result = mysqli_query(self::$db, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$db, $sql
            );
        }

        if (!($result instanceof MySQLi_Result))
            return $result;

        if ($list || $result->num_rows > 1) {
            $return = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $return[] = $row;
            }
        }
        else
            $return = mysqli_fetch_assoc($result);

        $result->free();

        return $return;
    }

    /**
     * Функция получения LAST_INSERT_ID()
     */
    final public static function getLastInsertId()
    {
        $result = mysqli_insert_id(self::$db);
        if (false === $result) {
            throw new DbException(
                'Не удалось получить LAST_INSERT_ID()', self::$db
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

        $result = mysqli_query(self::$db, $sql, MYSQLI_USE_RESULT);
        if (false === $result) {
            throw new DbException(
                'Не удалось выполнить запрос', self::$db, $sql
            );
        }

        $rows = mysqli_fetch_row($result);

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
