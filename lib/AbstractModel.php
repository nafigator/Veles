<?php
/**
 * Класс модели
 * @file    AbstractModel.php
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Апр 24 21:53:04 2012
 * @version
 */

/**
 * Класс модели
 * @author Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractModel {
    // Данные модели
    private $data = array();

    // Имя таблицы
    const TBL_NAME = NULL;

    /**
     * Магия для создания свойств модели
     * @param stirng $name
     * @param mixed  $value
     */
    final public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Магия для доступа к свойствам модели
     * @param string $name
     */
    final public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }

    /**
     * Магия для проверки свойства
     * @param string $name
     */
    final public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Получение данных по id
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
     * Получение данных по заданным параметрам
     * @param array $params
     */
    protected function getByParams($params)
    {

    }

    /**
     * Получение sql-параметров для insert
     * @return array $return
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    private function getInsertParams()
    {
        $return['fields'] = '';
        $return['values'] = '';

        foreach ($this->data as $name => $value) {
            $return['fields'] .= "`$name`, ";
            $return['values'] .= (is_string($value)) ? "'$value', " : "$value, ";
        }

        foreach ($return as $name => $value) {
            $return[$name] = substr($return[$name], 0, -2);
        }

        return $return;
    }

    /**
     * Получение sql-параметров для update
     * @return array $return
     * @todo протестировать алгоритм на время. Попробовать варианты с iterator, implode
     */
    private function getUpdateParams()
    {
        $return['update'] = '';

        foreach ($this->data as $name => $value) {
            $value = (is_string($value)) ? "'$value', " : "$value, ";
            $return['update'] .= "`$name` = $value";
        }

        return  substr($return['update'], 0, -2);
    }

    /**
     * Сохранение данных
     * @return bool|int
     */
    final public function save()
    {
        return (isset($this->data['id'])) ? $this->update() : $this->insert();
    }

    /**
     * Вставка данных непосредственно в базу
     * @return bool
     */
    private function insert()
    {
        $params = self::getInsertParams();

        $sql = '
            INSERT
                `' . $this::TBL_NAME . '`
                ' . $params['fields'] . '
            VALUES
                (' . $params['values'] . ')';

        return (Db::q($sql)) ? Db::getLastInsertId() : FALSE;
    }

    /**
     * Обновление данных в базе
     * @return bool
     */
    private function update()
    {
        $params = self::getUpdateParams();

        $sql = '
            UPDATE
                `' . $this::TBL_NAME . '`
            SET
                ' . $params . '
            WHERE
                id = ' . $this->data['id'];

        return Db::q($sql);
    }

    /**
     * Метод для инициализации параметров модели
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
     * Метод для получения параметров модели
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
     * Удаление данных
     * @param int $id
     */
    protected function deleteById($id)
    {
        $sql = '
            DELETE FROM
                `' . $this::TBL_NAME . '`
            WHERE
                id = ' . $id;

        return Db::q($sql);
    }
}
