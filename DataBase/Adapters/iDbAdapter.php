<?php
namespace Veles\DataBase\Adapters;

/**
 * Interface iDbAdapter
 *
 * Db adapters interface
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
interface iDbAdapter
{
	/**
	 * Get value from table row
	 *
	 * @param string $sql SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return string
	 */
	public function value($sql, array $params, $types);

	/**
	 * Get table row
	 *
	 * @param string $sql SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return array
	 */
	public function row($sql, array $params, $types);

	/**
	 * Get result collection
	 *
	 * @param string $sql SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return mixed
	 */
	public function rows($sql, array $params, $types);

	/**
	 * Transaction initialization
	 *
	 * @return bool
	 */
	public function begin();

	/**
	 * Transaction rollback
	 *
	 * @return bool
	 */
	public function rollback();

	/**
	 * Commit transaction
	 *
	 * @return bool
	 */
	public function commit();

	/**
	 * Launch non-SELECT query
	 *
	 * @param string $sql Non-SELECT SQL-query
	 * @param array $params Query values
	 * @param string|null $types Placeholders types
	 * @return bool
	 */
	public function query($sql, array $params, $types);

	/**
	 * Get last saved ID
	 *
	 * @return int
	 */
	public function getLastInsertId();

	/**
	 * Get found rows quantity
	 *
	 * @return int
	 */
	public function getFoundRows();

	/**
	 * Get PDOStatement
	 *
	 * Used in subscribers for getting error information
	 *
	 * @return mixed
	 */
	public function getStmt();

	/**
	 * Escape variable
	 *
	 * @param string $var
	 * @return string
	 */
	public function escape($var);
}