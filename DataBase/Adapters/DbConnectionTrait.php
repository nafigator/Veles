<?php
/**
 * Trait for handling connections pool functionality
 *
 * @file      DbConnectionTrait.php
 *
 * PHP version 8.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2013-12-31 15:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\DataBase\Adapters;

use Veles\DataBase\ConnectionPools\ConnectionPool;

/**
 * Trait DbConnectionTrait
 *
 * Contains connection pool getters and setters
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
trait DbConnectionTrait
{
	/** @var ConnectionPool */
	protected $pool;
	/** @var  \PDO */
	protected $resource;
	/** @var  string */
	protected $connection_name;

	/**
	 * Add connection pool
	 *
	 * @param ConnectionPool $pool
	 *
	 * @return $this
	 */
	public function setPool(ConnectionPool $pool)
	{
		$this->pool            = $pool;
		$this->connection_name = $pool->getDefaultConnectionName();

		return $this;
	}

	/**
	 * Get connection pool
	 *
	 * @return ConnectionPool $pool
	 */
	public function getPool()
	{
		return $this->pool;
	}

	/**
	 * Set default connection
	 *
	 * @param string $name Connection name
	 *
	 * @return $this
	 */
	public function setConnection($name)
	{
		$this->connection_name = $name;
		$this->resource        = null;

		return $this;
	}

	/**
	 * Get default connection resource
	 *
	 * return \PDO
	 */
	public function getResource()
	{
		if (null === $this->resource) {
			$this->resource = $this->pool
				->getConnection($this->connection_name)
				->getResource();
		}

		return $this->resource;
	}
}
