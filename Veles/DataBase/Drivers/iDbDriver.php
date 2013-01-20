<?php
/**
 * Интерфейс для работы с базой
 * @file    iDbDriver.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 06 10:13:35 2013
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase\Drivers;

/**
 * Интерфейс iDb
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iDbDriver
{
    /**
     * Получение соединения с базой
     * @return mixed
     */
    public static function getLink();

    /**
     * Метод для получения списка ошибок
     */
    public static function getErrors();

    /**
     * Функция получения FOUND_ROWS()
     * Использовать только после запроса с DbPaginator
     */
    public static function getFoundRows();

    /**
     * Функция получения LAST_INSERT_ID()
     */
    public static function getLastInsertId();

    /**
     * Метод для выполнения non-SELECT запросов
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return bool
     */
    public static function query($sql, $server);

    /**
     * Для SELECT, возвращающих значение одного поля
     *
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return mixed
     */
    public static function getValue($sql, $server);

    /**
     * Для SELECT, возвращающих значение одной строки таблицы
     *
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return array
     */
    public static function getRow($sql, $server);

    /**
     * Для SELECT, возвращающих значение коллекцию результатов
     *
     * @param string $sql SQL-запрос
     * @param string $server Имя сервера
     * @return array
     */
    public static function getRows($sql, $server);
}
