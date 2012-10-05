<?php
/**
 * Вспомогательный класс для формирования запросов
 * @file    QueryBuilder.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 21:55:54 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles\DataBase;

use \Exception;

/**
 * Класс QueryBuilder
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class QueryBuilder
{
    /**
     * Построение sql-запроса для insert
     * @param AbstractModel $model Экземпляр модели
     * @return array
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function insert($model)
    {
        $arr = array('fields' => '', 'values' => '');

        foreach ($model::$map as $property => $value) {
            $value = self::sanitize($model, $property);

            if (null === $value) continue;

            $arr['fields'] .= "`$property`, ";
            $arr['values'] .= (is_string($value)) ? "'$value', " : "$value, ";
        }

        array_walk($arr, function(&$val) {
            $val = rtrim($val, ', ');
        });

        $sql = '
            INSERT
                `' . $model::TBL_NAME . "`
                ($arr[fields])
            VALUES
                ($arr[values])
        ";

        return $sql;
    }

    /**
     * Построение sql-запроса для update
     * @param AbstractModel $model Экземпляр модели
     * @return array $sql
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function update($model)
    {
        $params = '';

        foreach ($model::$map as $property => $value) {
            $value = self::sanitize($model, $property);
            $value = (is_string($value)) ? "'$value'" : $value;
            $params .= "`$property` = $value, ";
        }

        $params = rtrim($params, ', ');

        $sql = '
            UPDATE
                `' . $model::TBL_NAME . "`
            SET
                $params
            WHERE
                id = $model->id
        ";

        return $sql;
    }

    /**
     * Построение sql-запроса для select
     * @param AbstractModel $model Экземпляр модели
     * @param int $id primary key
     * @return array $sql
     */
    final public static function getById($model, $id)
    {
        $id = (int) $id;

        $sql = '
            SELECT *
            FROM
                ' . $model::TBL_NAME . "
            WHERE
                `id` = $id
            LIMIT 1
        ";

        return $sql;
    }

    /**
     * Построение sql-запроса для delete
     * @param AbstractModel $model Экземпляр модели
     * @param array $ids Массив ID для удаления
     * @return array $sql
     */
    final public static function delete($model, $ids)
    {
        if (!$ids) {
            if (!isset($model->id)) {
                throw new Exception('Не найден id модели!');
            }

            $ids = $model->id;
        }

        if (!is_array($ids)) $ids = array($ids);

        array_walk($ids, function(&$value) {
            $value = (int) $value;
        });

        $ids = implode(',', $ids);

        $sql = '
            DELETE FROM
                `' . $model::TBL_NAME . "`
            WHERE
                id IN ($ids)
        ";

        return $sql;
    }

    /**
     * Построение запроса получения списка объектов
     * @param AbstractModel $model Экземпляр модели
     * @param DbFilter $filter Экземпляр фильтра
     * @param DbPaginator $pager Экземпляр пагинатора
     */
    final public static function find($model, $filter, $pager)
    {
        $fields = '';
        $select = 'SELECT';
        $where  = '';
        $group  = '';
        $having = '';
        $order  = '';
        $limit  = '';

        foreach ($model::$map as $property => $value) {
            $fields .= "`$property`, ";
        }

        $fields = rtrim($fields, ', ');

        if ($filter instanceof DbFilter) {
            $where  = $filter->getWhere();
            $group  = $filter->getGroup();
            $having = $filter->getHaving();
            $order  = $filter->getOrder();
        }

        if ($pager instanceof DbPaginator) {
            $offset = (int) $pager->getOffset() - 1;
            $select .= ' SQL_CALC_FOUND_ROWS';
            $where = (empty($where))
                ? "WHERE id > $offset"
                : "$where && id > $offset";

            $limit = $pager->getLimit();
        }

        $sql = "
            $select
                $fields
            FROM
                " . $model::TBL_NAME . "
            $where
            $group
            $having
            $order
            $limit
        ";

        return $sql;
    }

    /**
     * Построение произвольного запроса с постраничным выводом
     * @param string $sql Запрос
     * @param DbPaginator $pager Экземпляр постраничного вывода
     */
    final public static function setPage($sql, $pager)
    {
        $offset = (int) $pager->getOffset() - 1;
        $key    = $pager->getPrimaryKey();
        $sql    = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);

        $pattern = '/(WHERE\s(?:(?!GROUP|HAVING|ORDER|LIMIT).|\s)+)?((?:GROUP|HAVING|ORDER)(?:(?!LIMIT).|\s)+)*(LIMIT(?:\s|.)+)?$/i';
        preg_match($pattern, $sql, $matches);

        unset($matches[0]);
        if (empty($matches[2]))
            $matches[2] = '';

        $where = (empty($matches[1]))
            ? "WHERE $key > $offset $matches[2]"
            : "$matches[1] && $key > $offset $matches[2]";

        $sql = str_replace(implode('', $matches), $where, $sql) . $pager->getLimit();

        return $sql;
    }

    /**
     * Функция безопасности переменных
     * @param  $arg
     */
    private static function sanitize($model, $property) {
        if (!isset($model::$map[$property])) {
            throw new Exception (
                "Неизвестное свойство \"$property\" модели " . get_class($model)
            );
        }

        if (empty($model->$property)) {
            if (isset($model::$required_fields[$property])) {
                throw new Exception (
                    "Обязательное свойство \"$property\" модели " . get_class($model) . ' - пустое'
                );
            }
            else return;
        }

        $value = isset($model->$property) ? $model->$property : false;

        switch ($model::$map[$property]) {
            case 'int':
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
                $value = (int) $value;
                break;
            case 'float':
                $value = (float) $value;
                break;
            case 'char':
            case 'varchar':
            case 'text':
            case 'string':
                $value = mysql_real_escape_string((string) $value);
                break;
            default:
                throw new Exception (
                    "Неизвестный тип данных {$model::$map[$property]} в запросе"
                );
                break;
        }

        return $value;
    }
}
