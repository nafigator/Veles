<?php
/**
 * Exception содержащий код, текст и запрос sql-ошибки
 * @file    DbException.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 09 01:40:46 2012
 * @version
 */

namespace Veles;

use \Exception;

/**
 * Exception содержащий код и текст sql-ошибки
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class DbException extends Exception
{
    private $connect_error;
    private $sql_error;

    /**
     * Установка ошибки коннекта
     * @param   string Станадртный текст Exception
     */
    private function setConnectError($err)
    {
        $this->connect_error = $err;
    }

    /**
     * Установка ошибки SQL
     * @param   string Станадртный текст Exception
     */
    private function setSqlError($err)
    {
        $this->sql_error = $err;
    }

    /**
     * Конструктор
     * К стандартному Exception добавляется ошибка коннекта и текст ошибки запроса
     * @param   string Станадртный текст Exception
     * @param   string Текст sql-ошибки
     * @author  Yancharuk Alexander <alex@itvault.info>
     */
    final public function __construct($msg, $db)
    {
        parent::__construct($msg);
        $this->setConnectError($db->connect_error);
        $this->setSqlError($db->error);
    }

    /**
     * Возвращает ошибку соединения с базой
     * @return  string
     */
    final public function getConnectError()
    {
        return $this->connect_error;
    }

    /**
     * Возвращает ошибку соединения с базой
     * @return  string
     */
    final public function getSqlError()
    {
        return $this->sql_error;
    }
}
