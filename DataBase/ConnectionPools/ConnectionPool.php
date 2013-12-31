<?php
namespace Veles\DataBase\ConnectionPools;

use Veles\DataBase\Connections\PdoConnection;

/**
 * Class ConnectionPool
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ConnectionPool
{
	/** @var array */
	protected $pool;
	/** @var  string */
	protected $default_connection_name;

	/**
	 * @return string
	 */
	public function getDefaultConnectionName()
	{
		return $this->default_connection_name;
	}

	/**
	 * Добавление класса соединения в пул
	 *
	 * @param PdoConnection $conn
	 * @param bool $default Флаг является ли соединение соединением по-умолчанию
	 * @return $this
	 * @see DbConnection
	 */
	public function addConnection(PdoConnection $conn, $default = false)
	{
		$this->pool[$conn->getName()] = $conn;

		if ($default) {
			$this->default_connection_name = $conn->getName();
		}
		return $this;
	}

	/**
	 * Получение класса соединения по имени
	 *
	 * @param string $name Название соединения
	 * @return PdoConnection|null
	 * @see DbConnection
	 */
	public function getConnection($name)
	{
		return isset($this->pool[$name]) ? $this->pool[$name] : null;
	}
}
