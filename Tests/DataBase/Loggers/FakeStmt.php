<?php
namespace Veles\Tests\DataBase\Loggers;

/**
 * Class FakeStmt
 *
 * Нужен для тестирования класса PdoErrorLogger
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @group database
 */
class FakeStmt
{
	private $error_code;
	private $error_info;

	/**
	 * @return mixed
	 */
	public function errorCode()
	{
		return $this->error_code;
	}

	/**
	 * @param mixed $error_code
	 */
	public function setErrorCode($error_code)
	{
		$this->error_code = $error_code;
	}

	/**
	 * @return mixed
	 */
	public function errorInfo()
	{
		return $this->error_info;
	}

	/**
	 * @param mixed $error_info
	 */
	public function setErrorInfo($error_info)
	{
		$this->error_info = $error_info;
	}
}
