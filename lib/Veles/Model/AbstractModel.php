<?php
/**
 * Класс модели
 * @file    AbstractModel.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Апр 24 21:53:04 2012
 * @version
 */

namespace Veles\Model;

use \Exception,
    \Veles\DataBase\Db,
    \Veles\DataBase\Query;

/**
 * Класс модели
 * @author Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractModel {
    // Данные модели
    public $data = array();

    // Карта типов данных объекта
    public static $map = array();

    // Имя таблицы
    const TBL_NAME = null;

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
     * Вставка данных непосредственно в базу
     * @return bool
     */
    private function insert()
    {
        $sql = Query::buildInsert($this);

        return Db::q($sql) ? Db::getLastInsertId() : false;
    }

    /**
     * Обновление данных в базе
     * @return bool
     */
    private function update()
    {
        $sql = Query::buildUpdate($this);

        return Db::q($sql);
    }

    /**
     * Получение данных по id
     * @param int $id
     */
    protected function select()
    {
        $sql = Query::buildSelect($this);

        $result = Db::q($sql);

        foreach ($result as $name => $value) {
            $this->$name = $value;
        }

        return $result;
    }

    /**
     * Сохранение данных
     * @return bool|int
     */
    final public function save()
    {
        return isset($this->data['id']) ? $this->update() : $this->insert();
    }

    /**
     * Удаление данных
     * @param int $id
     */
    protected function delete()
    {
        $sql = Query::buildDelete($this);

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
}
