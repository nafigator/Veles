<?php
/**
 * ActiveRecord model
 *
 * @file      ActiveRecord.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      Втр Апр 24 21:53:04 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model;

use StdClass;
use Veles\DataBase\Db;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;
use Veles\Traits\DynamicPropHandler;

/**
 * Model class using ActiveRecord pattern
 *
 * @author Alexander Yancharuk <alex at itvault dot info>
 */
class ActiveRecord extends StdClass
{
	/**
	 * @const string|null Table name
	 */
	const TBL_NAME = null;
	/** @var QueryBuilder */
	protected $builder;
	/** @var array Data type map */
	protected $map = [];

	use DynamicPropHandler;

	/**
	 * Update data in database
	 *
	 * @return bool
	 * @throws \Exception
	 */
	protected function update()
	{
		$sql = $this->builder->update($this);

		return Db::query($sql);
	}

	/**
	 * Insert data in database
	 *
	 * @return bool
	 * @throws \Exception
	 */
	protected function insert()
	{
		$sql      = $this->builder->insert($this);
		$result   = Db::query($sql);
		$this->id = Db::getLastInsertId();

		return $result;
	}

	/**
	 * Method with true|false return and setting properties for current object
	 *
	 * @param $sql
	 *
	 * @return bool
	 * @throws \Exception
	 */
	protected function getResult($sql)
	{
		$result = Db::row($sql);

		if (empty($result)) {
			return false;
		}

		$this->setProperties($result);

		return true;
	}

	public function __construct()
	{
		$this->builder = new QueryBuilder;
	}

	/**
	 * Get data type map
	 *
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
	 * @throws \Exception
	 */
	public function getById($identifier)
	{
		$sql = $this->builder->getById($this, $identifier);

		return $this->getResult($sql);
	}

	/**
	 * Get object list by filter
	 *
	 * @param bool|DbFilter    $filter Filter object
	 * @param bool|DbPaginator $pager  Pagination object
	 *
	 * @return bool|array
	 * @throws \Exception
	 */
	public function getAll($filter = false, $pager = false)
	{
		$sql = $this->builder->find($this, $filter);

		if ($pager instanceof DbPaginator) {
			$sql = $this->builder->setPage($sql, $pager);
		}

		$result = Db::rows($sql);

		if (empty($result)) {
			return false;
		}

		if ($pager instanceof DbPaginator) {
			$pager->calcMaxPages();
		}

		return $result;
	}

	/**
	 * Save data
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function save()
	{
		return isset($this->id) ? $this->update() : $this->insert();
	}

	/**
	 * Delete data
	 *
	 * @param array|bool $ids Array of ID for delete
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function delete($ids = false)
	{
		if (!$ids) {
			if (!isset($this->id)) {
				throw new \Exception('Not found model id!');
			}

			$ids = $this->id;
		}

		if (!is_array($ids)) {
			$ids = [$ids];
		}

		$sql = $this->builder->delete($this, $ids);

		return Db::query($sql);
	}

	/**
	 * Get unique object
	 *
	 * @param bool|DbFilter $filter Filter object
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function find($filter = false)
	{
		$sql = $this->builder->find($this, $filter);

		return $this->getResult($sql);
	}

	/**
	 * @param QueryBuilder $builder
	 */
	public function setBuilder(QueryBuilder $builder)
	{
		$this->builder = $builder;
	}

	/**
	 * Query with pagination
	 *
	 * @param string           $sql   Query
	 * @param bool|DbPaginator $pager Pagination object
	 *
	 * @return array|bool
	 * @throws \Exception
	 */
	public function query($sql, $pager = false)
	{
		if ($pager instanceof DbPaginator) {
			$sql = $this->builder->setPage($sql, $pager);
		}

		$result = Db::rows($sql);

		if (empty($result)) {
			return false;
		}

		if ($pager instanceof DbPaginator) {
			$pager->calcMaxPages();
		}

		return $result;
	}
}
