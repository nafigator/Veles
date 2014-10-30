<?php
/**
 * Exception содержащий код, текст и запрос sql-ошибки
 * @file    DbException.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Мар 09 01:40:46 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

use Exception;

/**
 * Exception содержащий код и текст sql-ошибки
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbException extends Exception
{
	private $connect_error = null;
	private $sql_error     = null;
	private $sql_query     = null;

	/**
	 * Установка ошибки коннекта
	 * @param string $err Станадртный текст Exception
	 */
	private function setConnectError($err)
	{
		$this->connect_error = $err;
	}

	/**
	 * Установка ошибки SQL
	 * @param string $err Станадртный текст Exception
	 */
	private function setSqlError($err)
	{
		$this->sql_error = $err;
	}

	/**
	 * Установка ошибки SQL-запроса, вызвавшего ошибку
	 * @param string $sql Станадртный текст Exception
	 */
	private function setSqlQuery($sql)
	{
		$this->sql_query = $sql;
	}

	/**
	 * Exception с ошибкой коннекта и текстом ошибки запроса
	 * @param string $msg Текст ошибки
	 * @param resource|\mysqli $link Линк sql-соединения
	 * @param string $sql SQL-запрос
	 */
	public function __construct($msg, $link, $sql = null)
	{
		parent::__construct($msg);
		$this->setConnectError($link->connect_error);
		$this->setSqlError($link->error);

		if (null !== $sql) {
			$this->setSqlQuery($sql);
		}
	}

	/**
	 * Возвращает ошибку соединения с базой
	 * @return string
	 */
	public function getConnectError()
	{
		return $this->connect_error;
	}

	/**
	 * Возвращает ошибку соединения с базой
	 * @return  string
	 */
	public function getSqlError()
	{
		return $this->sql_error;
	}

	/**
	 * Установка ошибки SQL-запроса, вызвавшего ошибку
	 * @return string
	 */
	public function getSqlQuery()
	{
		return $this->sql_query;
	}
}
