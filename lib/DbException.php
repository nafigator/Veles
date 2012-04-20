<?php
/**
 * @file    DbException.class.php
 * @brief   Exception содержащий код, текст и запрос sql-ошибки
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 09 01:40:46 2012
 * @version
 */

/**
 * @class   DbException
 * @brief   Exception содержащий код и текст sql-ошибки
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class DbException extends Exception
{
    private $connect_error;
    private $sql_error;

    private function setConnectError($err)
    {
        $this->connect_error = $err;
    }

    private function setSqlError($err)
    {
        $this->sql_error = $err;
    }

    /**
     * @fn
     * @brief
     *
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
     * @fn      getConnectError
     * @brief   Возвращает ошибку соединения с базой
     *
     * @return  string
     */
    final public function getConnectError()
    {
        return $this->connect_error;
    }

    /**
     * @fn      getSqlError
     * @brief   Возвращает ошибку соединения с базой
     *
     * @return  string
     */
    final public function getSqlError()
    {
        return $this->sql_error;
    }
}
