<?php
namespace Veles\Tests\DataBase\Loggers;

use SplObserver;

/**
 * Class FakeSubject
 *
 * Нужен для тестирования класса PdoErrorLogger
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @group database
 */
class FakeSubject implements \SplSubject
{
	private $connection;
	private $stmt;

	public function attach(SplObserver $observer)
	{
	}

	public function detach(SplObserver $observer)
	{
	}


	public function notify()
	{
	}

	/**
	 * @return mixed
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * @param mixed $connection
	 */
	public function setConnection($connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @return mixed
	 */
	public function getStmt()
	{
		return $this->stmt;
	}

	/**
	 * @param mixed $stmt
	 */
	public function setStmt($stmt)
	{
		$this->stmt = $stmt;
	}
}
