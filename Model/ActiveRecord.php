<?php
/**
 * ActiveRecord model
 *
 * @file      ActiveRecord.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Апр 24 21:53:04 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model;

use StdClass;
use Traits\DynamicPropHandler;
use Veles\DataBase\Db;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;

/**
 * Model class using ActiveRecord pattern
 * @todo   Implements Observer functionality for sql and errors logging
 * @author Alexander Yancharuk <alex at itvault dot info>
 */
class ActiveRecord extends StdClass
{
	/**
	 * @const string|null Table name
	 */
	const TBL_NAME = null;
	/* @var iQueryBuilder */
	protected $builder;
	/**
	 * @var int|float|string $map Data type map
	 */
	protected $map = [];

	use DynamicPropHandler;

	public function __construct()
	{
		$this->builder = new QueryBuilder;
	}

	/**
	 * Get data type map
	 * @return array
	 */
	public function getMap()
	{
		return $this->map;
	}

	/**
	 * Get data by ID
	 *
	 * @param int $identifier Model ID
	 *
	 * @return bool
	 */
	public function getById($identifier)
	{
		$sql = $this->builder->getById($this, $identifier);

		$result = Db::row($sql);

		if (empty($result)) {
			return false;
		}

		$this->setProperties($result);

		return true;
	}

	/**
	 * Get object list by filter
	 *
	 * @param bool|DbFilter    $filter Filter object
	 * @param bool|DbPaginator $pager  Pagination object
	 *
	 * @return array
	 */
	public function getAll($filter = false, $pager = false)
	{
		$sql = $this->builder->find($this, $filter);
		$sql = $this->builder->setPage($sql, $pager);

		$result = Db::rows($sql);

		if (empty($result)) {
			return false;
		}

		$pager instanceof DbPaginator && $pager->calcMaxPages();

		return $result;
	}

	/**
	 * Save data
	 * @return bool|int
	 */
	public function save()
	{
		return isset($this->id) ? $this->update() : $this->insert();
	}

	/**
	 * Update data in database
	 * @return bool
	 */
	private function update()
	{
		$sql = $this->builder->update($this);

		return Db::query($sql);
	}

	/**
	 * Insert data in database
	 * @return int|bool
	 */
	private function insert()
	{
		$sql = $this->builder->insert($this);

		return Db::query($sql) ? Db::getLastInsertId() : false;
	}

	/**
	 * Delete data
	 *
	 * @param array|bool $ids Array of ID for delete
	 *
	 * @return bool
	 */
	public function delete($ids = false)
	{
		$sql = $this->builder->delete($this, $ids);

		return Db::query($sql);
	}

	/**
	 * Get unique object
	 *
	 * @param bool|DbFilter $filter Filter object
	 *
	 * @return bool
	 */
	public function find($filter = false)
	{
		$sql = $this->builder->find($this, $filter);

		$result = Db::row($sql);

		if (empty($result)) {
			return false;
		}

		$this->setProperties($result);

		return true;
	}

	/**
	 * @param iQueryBuilder $builder
	 */
	public function setBuilder($builder)
	{
		$this->builder = $builder;
	}

	/**
	 * Query with pagination
	 *
	 * @param string           $sql   Query
	 * @param bool|DbPaginator $pager Pagination object
	 *
	 * @todo Add Pager type hints
	 * @return array|bool
	 */
	public function query($sql, $pager = false)
	{
		if (false !== $pager) {
			$sql = $this->builder->setPage($sql, $pager);
		}

		$result = Db::rows($sql);

		if (empty($result)) {
			return false;
		}

		if (false !== $pager) {
			$pager->calcMaxPages();
		}

		return $result;
	}
}
