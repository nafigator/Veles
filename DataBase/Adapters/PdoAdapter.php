<?php
namespace Veles\DataBase\Adapters;

use PDO;
use Veles\DataBase\Exceptions\DbException;

/**
 * Class PdoAdapter
 *
 * Adapter PDO extension
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class PdoAdapter extends DbAdapterBase implements iDbAdapter
{
	// Save statement for ability to get error information
	/** @var  \PDOStatement */
	private $stmt;

	private $type = [
	   'i' => PDO::PARAM_INT,
	   'd' => PDO::PARAM_STR,
	   's' => PDO::PARAM_STR,
	   'b' => PDO::PARAM_LOB
	];

	private function bindParams($params, $types)
	{
		foreach ($params as $key => $param) {
			$type = isset($this->type[$types[$key]])
				? $this->type[$types[$key]]
				: PDO::PARAM_STR;
			// Placeholder numbers begins from 1
			$this->stmt->bindValue($key + 1, $param, $type);
		}
	}

	private function prepare($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();
	}

	/**
	 * Get value from table row
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return string
	 * @throws DbException
	 */
	public function value($sql, array $params, $types)
	{
		try {
			$this->prepare($sql, $params, $types);
			$result = $this->stmt->fetchColumn();
		} catch (\PDOException $e) {
			$this->setSql($sql);
			$this->setParams($params);
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}

		return $result;
	}

	/**
	 * Get table row
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return array
	 * @throws DbException
	 */
	public function row($sql, array $params, $types)
	{
		try {
			$this->prepare($sql, $params, $types);
			$result = $this->stmt->fetch();
		} catch (\PDOException $e) {
			$this->setSql($sql);
			$this->setParams($params);
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}

		return $result;
	}

	/**
	 * Get result collection
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return mixed
	 * @throws DbException
	 */
	public function rows($sql, array $params, $types)
	{
		try {
			$this->prepare($sql, $params, $types);
			$result = $this->stmt->fetchAll();
		} catch (\PDOException $e) {
			$this->setSql($sql);
			$this->setParams($params);
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}

		return $result;
	}

	/**
	 * Transaction initialization
	 *
	 * @return bool
	 * @throws DbException
	 */
	public function begin()
	{
		try {
			$result = $this->getConnection()->beginTransaction();
		} catch (\PDOException $e) {
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}

	/**
	 * Transaction rollback
	 *
	 * @return bool
	 * @throws DbException
	 */
	public function rollback()
	{
		try {
			$result = $this->getConnection()->rollBack();
		} catch (\PDOException $e) {
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}

	/**
	 * Commit transaction
	 *
	 * @return bool
	 * @throws DbException
	 */
	public function commit()
	{
		try {
			$result = $this->getConnection()->commit();
		} catch (\PDOException $e) {
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}

	/**
	 * Launch non-SELECT query
	 *
	 * @param string      $sql    Non-SELECT SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return bool
	 * @throws DbException
	 */
	public function query($sql, array $params, $types)
	{
		try {
			if (empty($params)) {
				return (bool)$this->getConnection()->query($sql);
			}

			$this->stmt = $this->getConnection()->prepare($sql);

			if (null === $types) {
				$result = $this->stmt->execute($params);
			} else {
				$this->bindParams($params, $types);
				$result = $this->stmt->execute();
			}
		} catch (\PDOException $e) {
			$this->setSql($sql);
			$this->setParams($params);
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}

		return $result;
	}

	/**
	 * Get last saved ID
	 *
	 * @return int
	 * @throws DbException
	 */
	public function getLastInsertId()
	{
		try {
			$result = (int) $this->getConnection()->lastInsertId();
		} catch (\PDOException $e) {
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}

	/**
	 * Get found rows quantity
	 *
	 * @return int
	 */
	public function getFoundRows()
	{
		return (int) $this->value('SELECT FOUND_ROWS()', [], null);
	}

	/**
	 * Get PDOStatement
	 *
	 * Used in subscribers for getting error information
	 *
	 * @return mixed
	 */
	public function getStmt()
	{
		return $this->stmt;
	}

	/**
	 * Escape variable
	 *
	 * @param string $var
	 *
	 * @return string
	 * @throws DbException
	 */
	public function escape($var)
	{
		try {
			$result = $this->getConnection()->quote($var);
		} catch (\PDOException $e) {
			$this->setException($e);
			$this->notify();
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}
}
