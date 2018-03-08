<?php
/**
 * Class for query building
 *
 * @file      QueryBuilder.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
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
class QueryBuilder implements QueryBuilderInterface
{
	/**
	 * @param $filter DbFilter
	 *
	 * @return array
	 */
	protected function extractParams(DbFilter $filter)
	{
		return [
			'where'  => $filter->getWhere(),
			'group'  => $filter->getGroup(),
			'having' => $filter->getHaving(),
			'order'  => $filter->getOrder()
		];
	}

	/**
	 * Построение sql-запроса для insert
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 *
	 * @return string
	 * @throws Exception
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

		$arr = array_map(
			function ($val) {
				return rtrim($val, ', ');
			},
			$arr
		);

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
	 *
	 * @param ActiveRecord $model
	 * @param mixed        $property
	 *
	 * @return mixed
	 * @throws Exception
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
	 *
	 * @param ActiveRecord $model Экземпляр модели
	 *
	 * @return string $sql
	 * @throws Exception
	 */
	public function update(ActiveRecord $model)
	{
		$params = '';
		$table  = $model::TBL_NAME;
		$properties = array_diff(array_keys($model->getMap()), ['id']);

		foreach ($properties as $property) {
			$value = $this->sanitize($model, $property);

			if (null === $value) {
				continue;
			}

			$params .= "\"$property\" = $value, ";
		}

		$params = rtrim($params, ', ');

		$sql = "
			UPDATE
				\"$table\"
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
		$table      = $model::TBL_NAME;

		$sql = "
			SELECT *
			FROM
				\"$table\"
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
	 * @param array        $ids   Массив ID для удаления
	 *
	 * @throws Exception
	 * @return string $sql
	 */
	public function delete(ActiveRecord $model, array $ids)
	{
		foreach ($ids as &$value) {
			$value = (int) $value;
		};

		$ids   = implode(',', $ids);
		$table = $model::TBL_NAME;

		$sql = "
			DELETE FROM
				\"$table\"
			WHERE
				id IN ($ids)
		";

		return $sql;
	}

	/**
	 * Построение запроса получения списка объектов
	 *
	 * @param ActiveRecord  $model  Экземпляр модели
	 * @param bool|DbFilter $filter Экземпляр фильтра
	 *
	 * @return string
	 */
	public function find(ActiveRecord $model, $filter)
	{
		$fields = '"' . implode('", "', array_keys($model->getMap())) . '"';
		$where = $group = $having = $order = '';

		if ($filter instanceof DbFilter) {
			$params = $this->extractParams($filter);
			extract($params, EXTR_IF_EXISTS);
		}

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
	 *
	 * @param string      $sql   Запрос
	 * @param DbPaginator $pager Экземпляр постраничного вывода
	 *
	 * @return string
	 */
	public function setPage($sql, DbPaginator $pager)
	{
		$sql = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
		return $sql . $pager->getSqlLimit();
	}
}
