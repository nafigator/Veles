<?php
namespace Veles\DataBase\Connections;

use Exception;

/**
 * Class DbConnection
 *
 * Базовый класс-контейнер для хранения общих для всех соединений параметров
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
abstract class DbConnection
{
	/** @var string */
	protected $user_name;
	/** @var string */
	protected $password;
	/** @var string */
	protected $name;
	/** @var mixed */
	protected $resource;

	/**
	 * @param string $name Уникальное название соединения
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * Создание соединения
	 *
	 * Реализуется в конкретном классе для каждого типа соединений
	 *
	 * @return mixed
	 */
	abstract function create();

	/**
	 * @return mixed
	 */
	public function getResource()
	{
		return $this->resource;
	}

	/**
	 * @param mixed $resource
	 */
	public function setResource($resource)
	{
		$this->resource = $resource;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @throws Exception
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @throws Exception
	 * @return string
	 */
	public function getUserName()
	{
		return $this->user_name;
	}

	/**
	 * @param string $user_name
	 * @return $this
	 */
	public function setUserName($user_name)
	{
		$this->user_name = $user_name;
		return $this;
	}
}