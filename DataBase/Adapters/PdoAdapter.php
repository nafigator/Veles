<?php
/**
 * PDO adapter class
 *
 * @file      PdoAdapter.php
 *
 * PHP version 7.1+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2013-12-31 15:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase\Adapters;

use PDO;
use PDOException;
use PDOStatement;
use Veles\DataBase\Exceptions\DbException;

/**
 * Class PdoAdapter
 *
 * Adapter PDO extension
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class PdoAdapter implements DbAdapterInterface
{
	// Save statement for ability to get error information
	/** @var  PDOStatement|bool */
	protected $stmt;

	protected $type = [
	   'i' => PDO::PARAM_INT,
	   'd' => PDO::PARAM_STR,
	   's' => PDO::PARAM_STR,
	   'b' => PDO::PARAM_LOB
	];

	use DbConnectionTrait;

	protected function bindParams(array $params, $types)
	{
		foreach ($params as $key => $param) {
			$type = isset($this->type[$types[$key]])
				? $this->type[$types[$key]]
				: PDO::PARAM_STR;
			// Placeholder numbers begins from 1
			$this->stmt->bindValue($key + 1, $param, $type);
		}
	}

	protected function prepare($sql, array $params, $types)
	{
		$this->stmt = $this->getResource()->prepare($sql);

		if (!$this->stmt) {
			throw new PDOException('SQLSTATE[HY000]: Unknown error: 1105 PDOStatement Creating failure');
		}

		if (null === $types) {
			$this->stmt->execute($params);

			return;
		}

		$this->bindParams($params, $types);
		$this->stmt->execute();
	}

	protected function execute($sql, array $params, $types)
	{
		$this->stmt = $this->getResource()->prepare($sql);

		if (!$this->stmt) {
			return false;
		}

		if (null !== $types) {
			$this->bindParams($params, $types);
		}

		return null === $types
			? $this->stmt->execute($params)
			: $this->stmt->execute();
	}

	/**
	 * Throw DbException with query info
	 *
	 * @param string       $sql
	 * @param array        $params
	 * @param PDOException $e
	 *
	 * @throws DbException
	 */
	protected function throwExceptionWithInfo($sql, array $params, PDOException $e)
	{
		$exception = new DbException($e->getMessage(), (int) $e->getCode(), $e);
		$exception->setSql($sql);
		$exception->setParams($params);

		throw $exception;
	}

	/**
	 * Get value from table row
	 *
	 * @param string      $sql    SQL-query
	 * @param array       $params Query values
	 * @param string|null $types  Placeholders types
	 *
	 * @return mixed
	 * @throws DbException
	 */
	public function value($sql, array $params, $types)
	{
		$result = '';

		try {
			$this->prepare($sql, $params, $types);
			$result = $this->stmt->fetchColumn();
		} catch (PDOException $e) {
			$this->throwExceptionWithInfo($sql, $params, $e);
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
	 * @return mixed              Depends on fetch type
	 * @throws DbException
	 */
	public function row($sql, array $params, $types)
	{
		$result = [];

		try {
			$this->prepare($sql, $params, $types);
			$result = $this->stmt->fetch();
		} catch (PDOException $e) {
			$this->throwExceptionWithInfo($sql, $params, $e);
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
	 * @return mixed              Depends on fetch type
	 * @throws DbException
	 */
	public function rows($sql, array $params, $types)
	{
		$result = [];

		try {
			$this->prepare($sql, $params, $types);
			$result = $this->stmt->fetchAll();
		} catch (PDOException $e) {
			$this->throwExceptionWithInfo($sql, $params, $e);
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
			$result = $this->getResource()->beginTransaction();
		} catch (PDOException $e) {
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
			$result = $this->getResource()->rollBack();
		} catch (PDOException $e) {
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
			$result = $this->getResource()->commit();
		} catch (PDOException $e) {
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
		$result = false;

		try {
			if (empty($params)) {
				return (bool) $this->getResource()->query($sql);
			}

			$result = $this->execute($sql, $params, $types);
		} catch (PDOException $e) {
			$this->throwExceptionWithInfo($sql, $params, $e);
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
			$result = (int) $this->getResource()->lastInsertId();
		} catch (PDOException $e) {
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}

	/**
	 * Get found rows quantity
	 *
	 * @return int
	 * @throws DbException
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
			$result = $this->getResource()->quote($var);
		} catch (PDOException $e) {
			throw new DbException($e->getMessage(), (int) $e->getCode(), $e);
		}
		return $result;
	}
}
