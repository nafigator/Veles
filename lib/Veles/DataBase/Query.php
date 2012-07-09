<?php
/**
 * Вспомогательный класс для формирования запросов
 * @file    Query.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 21:55:54 2012
 * @version
 */

namespace Veles\DataBase;

use \Exception;

/**
 * Класс Query
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Query
{
    /**
     * Построение sql-запроса для insert
     * @param AbstractModel $model Экземпляр модели
     * @return array $sql
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function buildInsert($model)
    {
        $arr['fields'] = '';
        $arr['values'] = '';

        foreach ($model::$map as $name => $value) {
            $value = self::sanitize($model, $name);
            $arr['fields'] .= "`$name`, ";
            $arr['values'] .= (is_string($value)) ? "'$value', " : "$value, ";
        }

        foreach ($arr as $name => $value) {
            $arr[$name] = substr($return[$name], 0, -2);
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
    final public static function buildUpdate($model)
    {
        $params = '';

        foreach ($model::$map as $name => $value) {
            $value = self::sanitize($model, $name);
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
                id = ' . $model->data['id'];

        return $sql;
    }

    /**
     * Построение sql-запроса для select
     * @param AbstractModel $model Экземпляр модели
     * @return array $sql
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    final public static function buildSelect($model)
    {
        $sql = '
            SELECT *
            FROM
                ' . $model::TBL_NAME . '
            WHERE
                `id` = ' . $model->data['id'] . '
            LIMIT 1
        ';

        return $sql;
    }

    /**
     * Построение sql-запроса для delete
     * @param AbstractModel $model Экземпляр модели
     * @return array $sql
     */
    final public static function buildDelete($model)
    {
        $sql = '
            DELETE FROM
                `' . $model::TBL_NAME . '`
            WHERE
                id = ' . $model->data['id'];

        return $sql;
    }

    /**
     * Функция безопасности переменных
     * @param  $arg
     */
    private static function sanitize($model, &$name) {
        if (empty($model->data[$name]) && isset($model::$required_fields[$name])) {
            throw new Exception (
                "Обязательное поле $name модели " . get_class($model) . ' - пустое'
            );
        }

        $value = isset($model->data[$name]) ? $model->data[$name] : false;

        switch ($model::$map[$name]) {
            case 'int':
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
                $value = (int) $value;
                break;
            case 'char':
            case 'varchar':
            case 'text':
            case 'string':
                $value = mysql_real_escape_string((string) $value);
                break;
            default:
                throw new Exception (
                    "Неизвестный тип данных {$model::$map[$name]} в запросе"
                );
                break;
        }

        return $value;
    }
}
