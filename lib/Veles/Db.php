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
 * @version
 */

namespace Veles;

use \Exception,
    \mysqli,
    \MySQLi_Result;

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
        try {
            if (NULL === ($db_params = Config::getParams('db'))) {
                throw new Exception('Не найдены параметры подключения к базе!');
            }

            self::$db = mysqli_connect(
                $db_params['host'],
                $db_params['user'],
                $db_params['password'],
                $db_params['base']
            );

            if (!self::$db instanceof mysqli) {
                throw new Exception('Не удалось подключиться к mysql');
            }
        }
        catch (Exception $e) {
            self::$errors[] = $e;
            //TODO: редирект на 500
        }
    }

    /**
     * Метод для выполнения запросов
     * @param   string Sql-запрос
     * @return  bool Если запрос выполенен без ошибок, возвращает TRUE
     */
    final public static function q($sql)
    {
        if (!self::$db instanceof mysqli)
            self::connect();

        try {
            $result = mysqli_query(self::$db, $sql, MYSQLI_USE_RESULT);
            if (FALSE === $result) {
                throw new DbException(
                    'Не удалось выполнить запрос', self::$db, $sql
                );
            }
        }
        catch (DbException $e) {
            self::$errors[] = $e;
        }

        if ($result instanceof MySQLi_Result) {
            if ($result->num_rows > 1)
                while ($return[] = mysqli_fetch_assoc($result));
            else
                $return = mysqli_fetch_assoc($result);

            $result->free();
        }
        else
            return $result;

        return $return;
    }

    /**
     * Функция получения LAST_INSERT_ID()
     */
    final public static function getLastInsertId()
    {
        try {
            $result = mysqli_insert_id(self::$db);
            if (FALSE === $result) {
                throw new DbException(
                    'Не удалось получить LAST_INSERT_ID()', self::$db, $sql
                );
            }
        }
        catch (DbException $e) {
            self::$errors[] = $e;
        }

        return $result;
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
