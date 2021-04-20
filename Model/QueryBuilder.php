<?php
/**
 * Class for query building
 *
 * @file      QueryBuilder.php
 *
 * PHP version 7.1+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
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
		$fields = $values = '';

		foreach (array_keys($model->getMap()) as $property) {
			$value = $this->sanitize($model, $property);

			if (null === $value) {
				continue;
			}

			$fields .= "\"$property\", ";
			$values .= "$value, ";
		}

		$fields = rtrim($fields, ', ');
		$values = rtrim($values, ', ');

		return "INSERT \"" . $model::TBL_NAME . "\" ($fields) VALUES ($values)";
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

		$type = $model->getMap()[$property];

		if ('string' === $type) {
			return Db::escape($model->$property);
		}

		$value = $model->$property;
		settype($value, $type);

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
		$properties = array_diff_key($model->getMap(), ['id' => 1]);

		foreach (array_keys($properties) as $property) {
			$value = $this->sanitize($model, $property);

			if (null === $value) {
				continue;
			}

			$params .= "\"$property\" = $value, ";
		}

		$params = rtrim($params, ', ');

		return "UPDATE \"" . $model::TBL_NAME . "\" SET $params WHERE id = $model->id";
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

		return "SELECT * FROM \"" . $model::TBL_NAME . "\" WHERE id = $identifier LIMIT 1";
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

		return "DELETE FROM \"" . $model::TBL_NAME . "\" WHERE id IN ($ids)";
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

		return rtrim("SELECT $fields FROM \"" . $model::TBL_NAME . "\" $where $group $having $order");
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
