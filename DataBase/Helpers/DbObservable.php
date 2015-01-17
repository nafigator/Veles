<?php
/**
 * @file    DbObservable.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-01-17 07:53
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase\Helpers;

use Veles\Helpers\Observable;

/**
 * Class DbObservable
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class DbObservable extends Observable
{
	private $sql;
	private $params;
	private $exception;

	/**
	 * @return mixed
	 */
	public function getException()
	{
		return $this->exception;
	}

	/**
	 * @param \PDOException $exception
	 */
	public function setException(\PDOException $exception)
	{
		$this->exception = $exception;
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
	public function setParams(array $params)
	{
		$this->params = $params;
	}
}
