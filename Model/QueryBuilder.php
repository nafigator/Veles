<?php
/**
 * Class for query building
 *
 * @file      QueryBuilder.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Сбт Июл 07 21:55:54 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model;

use Exception;
use Veles\DataBase\Db;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;

/**
 * Класс QueryBuilder
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class QueryBuilder implements iQueryBuilder
{
	/**
	 * @param $filter DbFilter
	 *
	 * @return array
	 */
	protected function extractParams($filter)
	{
		$where = $group = $having = $order = '';

		if ($filter instanceof DbFilter) {
			$where  = $filter->getWhere();
			$group  = $filter->getGroup();
			$having = $filter->getHaving();
			$order  = $filter->getOrder();
		}

		return [$where, $group, $having, $order];
	}

	/**
	 * Построение sql-запроса для insert
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 *
	 * @return string
	 */
	public function insert(ActiveRecord $model)
	{
		$arr = ['fields' => '', 'values' => ''];

		foreach ($model->getMap() as $property => $value) {
			$value = $this->sanitize($model, $property);

			if (null === $value) {
				continue;
			}

			$arr['fields'] .= "\"$property\", ";
			$arr['values'] .= "$value, ";
		}

		foreach($arr as &$val) { $val = rtrim($val, ', '); }

		$sql = '
			INSERT
				"' . $model::TBL_NAME . "\"
				($arr[fields])
			VALUES
				($arr[values])
		";

		return $sql;
	}

	/**
	 * Функция безопасности переменных
	 * @param ActiveRecord $model
	 * @param $property
	 * @throws Exception
	 * @return mixed
	 */
	private function sanitize(ActiveRecord $model, $property)
	{
		if (!isset($model->$property)) {
			return null;
		}

		switch ($model->getMap()[$property]) {
			case 'int':
				$value = (int) $model->$property;
				break;
			case 'float':
				$value = (float) $model->$property;
				break;
			case 'string':
				$value = Db::escape($model->$property);
				break;
			default:
				$value = null;
				break;
		}

		return $value;
	}

	/**
	 * Построение sql-запроса для update
	 * @param ActiveRecord $model Экземпляр модели
	 * @return string $sql
	 * @todo протестировать алгоритм на время.
	 * Попробовать варианты с iterator, implode
	 */
	public function update(ActiveRecord $model)
	{
		$params = '';

		$properties = array_keys($model->getMap());
		foreach ($properties as $property) {
			$value = $this->sanitize($model, $property);

			if (null === $value || 'id' === $property) {
				continue;
			}

			$params .= "\"$property\" = $value, ";
		}

		$params = rtrim($params, ', ');

		$sql = '
			UPDATE
				"' . $model::TBL_NAME . "\"
			SET
				$params
			WHERE
				id = $model->id
		";

		return $sql;
	}

	/**
	 * Построение sql-запроса для select
	 * @param ActiveRecord $model Экземпляр модели
	 * @param int $identifier primary key
	 * @return string $sql
	 */
	public function getById(ActiveRecord $model, $identifier)
	{
		$identifier = (int) $identifier;

		$sql = '
			SELECT *
			FROM
				"' . $model::TBL_NAME . "\"
			WHERE
				id = $identifier
			LIMIT 1
		";

		return $sql;
	}

	/**
	 * Построение sql-запроса для delete
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 * @param array|string $ids Массив ID для удаления
	 * @throws Exception
	 * @return string $sql
	 */
	public function delete(ActiveRecord $model, $ids)
	{
		if (!$ids) {
			if (!isset($model->id)) {
				throw new Exception('Not found model id!');
			}

			$ids = $model->id;
		}

		if (!is_array($ids)) {
			$ids = [$ids];
		}

		foreach ($ids as &$value) {
			$value = (int) $value;
		};

		$ids = implode(',', $ids);

		$sql = '
			DELETE FROM
				"' . $model::TBL_NAME . "\"
			WHERE
				id IN ($ids)
		";

		return $sql;
	}

	/**
	 * Построение запроса получения списка объектов
	 * @param ActiveRecord $model Экземпляр модели
	 * @param DbFilter $filter Экземпляр фильтра
	 * @return string
	 */
	public function find(ActiveRecord $model, $filter)
	{
		$fields = '"' . implode('", "', array_keys($model->getMap())) . '"';

		list($where, $group, $having, $order) = $this->extractParams($filter);

		$sql = "
			SELECT
				$fields
			FROM
				\"" . $model::TBL_NAME . "\"
			$where
			$group
			$having
			$order
		";

		return rtrim($sql);
	}

	/**
	 * Построение произвольного запроса с постраничным выводом
	 * @param string $sql Запрос
	 * @param DbPaginator $pager Экземпляр постраничного вывода
	 * @return string
	 */
	public function setPage($sql, $pager)
	{
		if ($pager instanceof DbPaginator) {
			$sql = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
			return $sql . $pager->getSqlLimit();
		}

		return $sql;
	}
}
