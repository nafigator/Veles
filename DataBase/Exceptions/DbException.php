<?php
/**
 * General db exception class
 *
 * @file      DbException.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Птн Мар 09 01:40:46 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\DataBase\Exceptions;

use Exception;

/**
 * General db exception class
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class DbException extends Exception
{
	protected $ansi_code;
	protected $sql    = '';
	protected $params = [];

	public function __construct($msg, $code, $exception)
	{
		parent::__construct($msg, $code, $exception);

		if ($exception instanceof \PDOException) {
			$pattern1 = '/SQLSTATE\[(.+)\]:[\s\w]+: ([\w\d]+) ([\s\S]+)$/';
			$pattern2 = '/SQLSTATE\[(.+)\] \[([\w\d]+)\] ([\s\S]+)/';

			preg_match($pattern1, $exception->getMessage(), $match)
			or preg_match($pattern2, $exception->getMessage(), $match);

			$this->setAnsiCode($match[1]);
			$this->code    = (int) $match[2];
			$this->message = $match[3];

			if (isset($exception->errorInfo['sql'])) {
				$this->setSql($exception->errorInfo['sql']);
			}
			if (isset($exception->errorInfo['params'])) {
				$this->setParams($exception->errorInfo['params']);
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function getAnsiCode()
	{
		return $this->ansi_code;
	}

	/**
	 * @param mixed $ansi_code
	 */
	public function setAnsiCode($ansi_code)
	{
		$this->ansi_code = $ansi_code;
	}

	/**
	 * @return string
	 */
	public function getSql()
	{
		return $this->sql;
	}

	/**
	 * @param string $sql
	 */
	public function setSql($sql)
	{
		$this->sql = $sql;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * @param array $params
	 */
	public function setParams($params)
	{
		$this->params = $params;
	}
}
