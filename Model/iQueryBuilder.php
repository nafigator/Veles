<?php
/**
 * Query builder interface
 *
 * @file      iQueryBuilder.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2014-11-23 00:29
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model;

use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;

/**
 * Interface iQueryBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
interface iQueryBuilder
{
	/**
	 * Построение sql-запроса для insert
	 * @param ActiveRecord $model Экземпляр модели
	 * @return string
	 */
	public function insert(ActiveRecord $model);

	/**
	 * Построение sql-запроса для update
	 * @param ActiveRecord $model Экземпляр модели
	 * @return string $sql
	 */
	public function update(ActiveRecord $model);

	/**
	 * Построение sql-запроса для select
	 * @param ActiveRecord $model Экземпляр модели
	 * @param int $identifier primary key
	 * @return string $sql
	 */
	public function getById(ActiveRecord $model, $identifier);

	/**
	 * Построение sql-запроса для delete
	 * @param ActiveRecord $model Экземпляр модели
	 * @param mixed $ids Массив ID для удаления
	 * @throws \Exception
	 * @return string $sql
	 */
	public function delete(ActiveRecord $model, $ids);

	/**
	 * Построение запроса получения списка объектов
	 * @param ActiveRecord $model Экземпляр модели
	 * @param bool|DbFilter $filter Экземпляр фильтра
	 * @return string
	 */
	public function find(ActiveRecord $model, $filter);

	/**
	 * Построение произвольного запроса с постраничным выводом
	 * @param string $sql Запрос
	 * @param DbPaginator $pager Экземпляр постраничного вывода
	 * @return string
	 */
	public function setPage($sql, DbPaginator $pager);
}
