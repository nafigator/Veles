<?php
/**
 * @file    Db.class.inc
 * @brief   Класс соединения с базой. Для использования необходимо в php наличие
 * mysqli расширения.
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 09 03:25:07 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class   Db
 * @brief   Класс соединения с базой
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Db {
    const MYSQL_SERVER   = 'localhost';
    const MYSQL_USER     = 'root';
    const MYSQL_PASSWORD = '';
    const MYSQL_BASE     = 'ts';

    private static $db;
    private static $_debug = array();

    /**
     * @fn    connect
     * @brief Метод создаёт экземпляр mysqli класса и сохраняет его в self::$db.
     * Нечто наподобие классического синглтона.
     */
    private static function connect()
    {
        try {
            self::$db = new mysqli (
                self::MYSQL_SERVER,
                self::MYSQL_USER,
                self::MYSQL_PASSWORD,
                self::MYSQL_BASE
            );

            if (!self::$db instanceof mysqli) {
                throw new DbException('Не удалось создать экземпляр класса mysqli');
            }
        }
        catch (DbException $e) {
            self::$_debug[] = $e;
        }
    }

    /**
     * @fn      q
     * @brief   Метод для выполнения запросов
     *
     * @param   string Sql-запрос
     * @return  bool Если запрос выполенен без ошибок, возвращает TRUE
     */
    final public static function q($sql)
    {
        if (!self::$db instanceof mysqli)
            self::connect();

        try {
            $result = self::$db->query($sql);
            if ( $result !== TRUE) {
                throw new DbException(
                    'Не удалось выполнить запрос', self::$db, $sql
                );
            }
        }
        catch (DbException $e) {
            self::$_debug[] = $e;
        }

        return $result;
    }

    /**
     * @fn      getDebugData
     * @brief   Метод возвращает массив с ошибками
     *
     * @return  array $_debug
     */
    final public static function getDebugData()
    {
        return self::$_debug;
    }
}
