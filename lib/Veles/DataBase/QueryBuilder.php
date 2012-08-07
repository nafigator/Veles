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
     * @return array $sql
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function insert($model)
    {
        $arr['fields'] = '';
        $arr['values'] = '';

        foreach ($model::$map as $property => $value) {
            $value = self::sanitize($model, $property);
            $arr['fields'] .= "`$property`, ";
            $arr['values'] .= (is_string($value)) ? "'$value', " : "$value, ";
        }

        foreach ($arr as $name => $value) {
            $arr[$name] = substr($value, 0, -2);
        }

        $sql = '
            INSERT
                `' . $model::TBL_NAME . '`
                (' . $arr['fields'] . ')
            VALUES
                (' . $arr['values'] . ')';

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
            $value = (is_string($value)) ? "'$value', " : "$value, ";
            $params .= "`$name` = $value";
        }

        $params = substr($params, 0, -2);

        $sql = '
            UPDATE
                `' . $model::TBL_NAME . '`
            SET
                ' . $params . '
            WHERE
                id = ' . $model->id;

        return $sql;
    }

    /**
     * Построение sql-запроса для select
     * @param AbstractModel $model Экземпляр модели
     * @param int $id primary key
     * @return array $sql
     */
    final public static function find($model, $id)
    {
        $id = self::sanitize($model, 'id');

        $sql = '
            SELECT *
            FROM
                ' . $model::TBL_NAME . '
            WHERE
                `id` = ' . $id . '
            LIMIT 1
        ';

        return $sql;
    }

    /**
     * Построение sql-запроса для delete
     * @param AbstractModel $model Экземпляр модели
     * @param int $id primary key
     * @return array $sql
     */
    final public static function delete($model, $id)
    {
        $id = self::sanitize($model, 'id');

        $sql = '
            DELETE FROM
                `' . $model::TBL_NAME . '`
            WHERE
                id = ' . $id;

        return $sql;
    }

    /**
     * Построение запроса получения списка объектов
     * @param AbstractModel $model Экземпляр модели
     * @param Pagination $pager Экземпляр пагинатора
     */
    final public static function getList($model, $pager, $filter)
    {
        $limit = '';
        $where = '';

        foreach ($model::$map as $property => $value) {
            $value = self::sanitize($model, $property);
            $fields .= "`$property`, ";
        }

        $fields = substr($value, 0, -2);

        if ($filter instanceof AbstractFilter) {
            foreach ($filter->condition as $field => $cond) {
                $where .= " `$field` $cond[operation] $cond[value], ";
            }

            $where = substr($value, 0, -2);
        }

        if ($pager instanceof AbstractPagination) {
            $where = 'id >= ' . $pager->offset . $where;
            $limit = 'LIMIT ' . $pager->rows;
        }

        $sql = '
            SELECT
                ' . $fields . '
            FROM
                ' . $model::TBL_NAME . '
            WHERE
                ' . $where . '
            ' . $limit . '
        ';

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

        if (empty($model->$property) && isset($model::$required_fields[$property])) {
            throw new Exception (
                "Обязательное свойство \"$property\" модели " . get_class($model) . ' - пустое'
            );
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
