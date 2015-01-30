<?php
/**
 * General db exception class
 * @file    DbException.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Птн Мар 09 01:40:46 2012
 * @copyright The BSD 3-Clause License
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

	public function __construct($msg, $code, $exception)
	{
		parent::__construct($msg, $code, $exception);

		if ($exception instanceof \PDOException) {
			$pattern1 = '/SQLSTATE\[(.+)\]:[\s\w]+: ([\w\d]+) (.+)$/';
			$pattern2 = '/SQLSTATE\[(.+)\] ([\w\d]+) (.+)$/';

			preg_match($pattern1, $exception->getMessage(), $match)
			or preg_match($pattern2, $exception->getMessage(), $match);

			$this->setAnsiCode($match[1]);
			$this->code    = $match[2];
			$this->message = $match[3];
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
}
