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
    \Veles\DataBase\DbPaginator,
    \Veles\DataBase\QueryBuilder;

/**
 * Класс модели
 * @author Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractModel
{
    // Данные модели
    protected $data = array();

    // Карта типов данных объекта
    public static $map = array();

    // Обязательные свойства объекта, без наличия которых запись в базу не происходит
    public static $required_fields = array();

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
     * Конструктор модели
     */
    final public function __construct($id = null)
    {
        if (null !== $id)
            $this->getById($id);
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
    final public function getById($id)
    {
        $sql = QueryBuilder::getById($this, $id);

        $result = Db::q($sql);

        if (empty($result))
            return false;

        $this->setProperties($result);

        return true;
    }

    /**
     * Сохранение данных
     * @return bool|int
     */
    final public function save()
    {
        return isset($this->id) ? $this->update() : $this->insert();
    }

    /**
     * Удаление данных
     * @param array $ids
     */
    final public function delete($ids = false)
    {
        $sql = QueryBuilder::delete($this, $ids);

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
     * Получение уникального объекта
     * @param DbFilter $filter Объект фильтра
     */
    final public function find($filter = false)
    {
        $sql = QueryBuilder::find($this, $filter);

        $result = Db::q($sql);

        if (empty($result))
            return false;

        $this->setProperties($result);

        return true;
    }

    /**
     * Произвольный запрос с постраничным выводом
     * @param string $sql Запрос
     * @param DbPagination $pager Объект постраничного вывода
     */
    final protected function query($sql, $pager = false)
    {
        if ($pager)
            $sql = QueryBuilder::setPage($sql, $pager);

        $result = Db::q($sql, true);

        if (empty($result))
            return false;

        if ($pager)
            $pager->calcMaxPages();

        return $result;
    }
}
