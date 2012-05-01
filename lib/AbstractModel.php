<?php
/**
 * @file    AbstractModel
 * @brief   Класс модели
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Апр 24 21:53:04 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class AbstractModel
 * @brief Класс модели
 */
abstract class AbstractModel {
    // Данные модели
    private $data = array();

    // Имя таблицы
    const TBL_NAME = '';

    /**
     * @fn    __set
     * @brief Магия для создания свойств модели
     *
     * @param stirng $name
     * @param mixed  $value
     */
    final public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @fn    __get
     * @brief Магия для доступа к свойствам модели
     *
     * @param string $name
     */
    final public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    /**
     * @fn    __isset
     * @brief Магия для проверки свойства
     *
     * @param string $name
     */
    final public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @fn    getById
     * @brief Получение данных по id
     *
     * @param int $id
     */
    protected function getById($id)
    {
        $sql = '
            SELECT *
            FROM
                ' . $this::TBL_NAME . '
            WHERE
                `id` = ' . $id . '
            LIMIT 1
        ';

        $result = Db::q($sql);

        foreach ($result as $name => $value) {
            $this->$name = $value;
        }

        return $result;
    }

    /**
     * @fn    getByParams
     * @brief Получение данных по заданным параметрам
     *
     * @param array $params
     */
    protected function getByParams($params)
    {

    }

    /**
     * @fn    getSqlParams
     * @brief Получение sql-параметров
     *
     * @return array $return
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    private function getSqlParams()
    {
        $return = array();
        foreach ($this->data as $name => $value) {
            $return['fields'] .= "`$name`, ";
            $return['values'] .= (is_string($value)) ? "'$value', " : "$value, ";
            $return['update'] .= "`$name` = VALUES(`$name`), ";
        }

        foreach ($return as $name => $value) {
            $return[$name] = substr($return[$name], 0, -2);
        }
    }

    /**
     * @fn    save
     * @brief Сохранение данных
     *
     * @param array $params
     */
    protected function save()
    {
        $params = self::getSqlParams();

        $sql = '
            INSERT
                `' . $this::TBL_NAME . '`
                ' . $params['fields'] . '
            VALUES
                (' . $params['values'] . ')
            ON DUPLICATE KEY UPDATE
                `id` = LAST_INSERT_ID(`id`),
                ' . $params['update'];

        return (Db::q($sql)) ? Db::getLastInsertId() : FALSE;
    }

    /**
     * @fn      setProperties
     * @brief   Метод для инициализации параметров модели
     *
     * @param   array Массив с требуемыми параметрами в ключах массива
     * @return  array
     */
    final public function setProperties(&$properties)
    {
        foreach ($properties as $property_name => $value) {
            $this->$property_name = $value;
        }
    }

    /**
     * @fn      getProperties
     * @brief   Метод для получения параметров модели
     *
     * @param   array Массив с требуемыми параметрами в ключах массива
     * @return  array
     */
    final public function getProperties(&$properties)
    {
        foreach ($properties as $property_name => $value) {
            if (isset($this->$property_name)) {
                $properties[$property_name] = $this->$property_name;
            }
        }
    }

    /**
     * @fn    deleteById
     * @brief Удаление данных
     *
     * @param int $id
     */
    protected function deleteById($id)
    {

    }
}
