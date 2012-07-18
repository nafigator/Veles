<?php
/**
 * Класс модели
 * @file    AbstractModel.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Апр 24 21:53:04 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles\Model;

use \Veles\DataBase\Db,
    \Veles\DataBase\QueryBuilder;

/**
 * Класс модели
 * @author Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractModel {
    // Данные модели
    protected $data = array();

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
        $sql = QueryBuilder::insert($this);

        return Db::q($sql) ? Db::getLastInsertId() : false;
    }

    /**
     * Обновление данных в базе
     * @return bool
     */
    private function update()
    {
        $sql = QueryBuilder::update($this);

        return Db::q($sql);
    }

    /**
     * Получение данных по id
     * @param int $id
     */
    protected function select()
    {
        $sql = QueryBuilder::select($this);

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
        $sql = QueryBuilder::delete($this);

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
