<?php
/**
 * Query builder interface
 *
 * @file      QueryBuilderInterface.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2014-11-23 00:29
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model;

use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;

/**
 * Interface QueryBuilderInterface
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
interface QueryBuilderInterface
{
	/**
	 * Building sql-request for insert operation
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 *
	 * @return string
	 */
	public function insert(ActiveRecord $model);

	/**
	 * Building sql-request for update operation
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 *
	 * @return string $sql
	 */
	public function update(ActiveRecord $model);

	/**
	 * Building sql-request for select-operation
	 *
	 * @param ActiveRecord $model      Экземпляр модели
	 * @param int          $identifier primary key
	 *
	 * @return string $sql
	 */
	public function getById(ActiveRecord $model, $identifier);

	/**
	 * Building sql-request for delete-operation
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 * @param array        $ids   Массив ID для удаления
	 *
	 * @throws \Exception
	 * @return string $sql
	 */
	public function delete(ActiveRecord $model, array $ids);

	/**
	 * Build request for array of object result
	 *
	 * @param ActiveRecord  $model  Экземпляр модели
	 * @param bool|DbFilter $filter Экземпляр фильтра
	 *
	 * @return string
	 */
	public function find(ActiveRecord $model, $filter);

	/**
	 * Build custom request with paginated result
	 *
	 * @param string      $sql   Запрос
	 * @param DbPaginator $pager Экземпляр постраничного вывода
	 *
	 * @return string
	 */
	public function setPage($sql, DbPaginator $pager);
}
