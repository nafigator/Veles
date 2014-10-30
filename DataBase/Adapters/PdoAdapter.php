<?php
namespace Veles\DataBase\Adapters;

use PDO;

/**
 * Class PdoAdapter
 *
 * Adapter PDO extension
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
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

	/**
	 * Get value from table row
	 *
	 * @param string $sql SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return string
	 */
	public function value($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();

		return $this->stmt->fetchColumn();
	}

	/**
	 * Get table row
	 *
	 * @param string $sql SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return array
	 */
	public function row($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();

		return $this->stmt->fetch();
	}

	/**
	 * Get result collection
	 *
	 * @param string $sql SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return mixed
	 */
	public function rows($sql, array $params, $types)
	{
		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$this->stmt->execute();
		}

		$this->notify();

		return $this->stmt->fetchAll();
	}

	/**
	 * Transaction initialization
	 *
	 * @return bool
	 */
	public function begin()
	{
		return $this->getConnection()->beginTransaction();
	}

	/**
	 * Transaction rollback
	 *
	 * @return bool
	 */
	public function rollback()
	{
		return $this->getConnection()->rollBack();
	}

	/**
	 * Commit transaction
	 *
	 * @return bool
	 */
	public function commit()
	{
		return $this->getConnection()->commit();
	}

	/**
	 * Launch non-SELECT query
	 *
	 * @param string $sql Non-SELECT SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return bool
	 */
	public function query($sql, array $params, $types)
	{
		if (empty($params)) {
			return (bool) $this->getConnection()->query($sql);
		}

		$this->stmt = $this->getConnection()->prepare($sql);

		if (null === $types) {
			$result = $this->stmt->execute($params);
		} else {
			$this->bindParams($params, $types);
			$result = $this->stmt->execute();
		}

		$this->notify();

		return $result;
	}

	/**
	 * Get last saved ID
	 *
	 * @return int
	 */
	public function getLastInsertId()
	{
		return (int) $this->getConnection()->lastInsertId();
	}

	/**
	 * Get found rows quantity
	 *
	 * @return int
	 */
	public function getFoundRows()
	{
		$result = $this->value('SELECT FOUND_ROWS()', [], null);

		$this->notify();

		return (int) $result;
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
	 * @return string
	 */
	public function escape($var)
	{
		return $this->getConnection()->quote($var);
	}
}
