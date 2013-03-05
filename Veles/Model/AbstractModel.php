<?php
/**
 * Класс модели
 * @file    AbstractModel.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Апр 24 21:53:04 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Model;

use \Veles\DataBase\Db;
use \Veles\DataBase\DbPaginator;
use \Veles\DataBase\DbFilter;
use \Veles\DataBase\QueryBuilder;

/**
 * Класс модели
 * @author Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractModel
{
    /**
     * @var array $data Данные модели
     */
    protected $data = array();

    /**
     * @var int|float|string $map Карта типов данных объекта
     */
    protected static $map = array();

    /**
     * @const string|null Имя таблицы
     */
    const TBL_NAME = null;

    /**
     * Магия для создания свойств модели
     * @param string $name
     * @param mixed  $value
     */
    final public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Магия для доступа к свойствам модели
     * @param string $name
     * @return mixed
     */
    final public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    /**
     * Магия для проверки свойства
     * @param string $name
     * @return bool
     */
    final public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Конструктор модели
     * @param int $identifier ID модели
     */
    final public function __construct($identifier = null)
    {
        null !== $identifier && $this->getById($identifier);
    }

    /**
     * Получение карты данных модели
     * @return array
     */
    final public static function getMap()
    {
        return static::$map;
    }

    /**
     * Вставка данных непосредственно в базу
     * @return bool
     */
    private function insert()
    {
        $sql = QueryBuilder::insert($this);

        return Db::query($sql) ? Db::getLastInsertId() : false;
    }

    /**
     * Обновление данных в базе
     * @return bool
     */
    private function update()
    {
        $sql = QueryBuilder::update($this);

        return Db::query($sql);
    }

    /**
     * Получение данных по ID
     * @param int $identifier ID модели
     * @return bool
     */
    final public function getById($identifier)
    {
        $sql = QueryBuilder::getById($this, $identifier);

        $result = Db::getRow($sql);

        if (empty($result)) {
            return false;
        }

        $this->setProperties($result);

        return true;
    }

    /**
     * Получение списка объектов по фильтру
     * @param bool|DbFilter $filter Объект фильтра
     * @param bool|DbPaginator $pager Объект постраничного вывода
     * @return array Массив с найденными по фильтру данными
     */
    final public function getAll($filter = false, $pager = false)
    {
        $sql = QueryBuilder::find($this, $filter);
        $sql = QueryBuilder::setPage($sql, $pager);

        $result = Db::getRows($sql);

        if (empty($result)) {
            return false;
        }

        $pager instanceof DbPaginator && $pager->calcMaxPages();

        return $result;
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
     * @param array|bool $ids
     * @return bool
     */
    final public function delete($ids = false)
    {
        $sql = QueryBuilder::delete($this, $ids);

        return Db::query($sql);
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
        $tmp_props = array_keys($properties);
        foreach ($tmp_props as $property_name) {
            isset($this->$property_name)
                && $properties[$property_name] = $this->$property_name;
        }
    }

    /**
     * Получение уникального объекта
     * @param bool|DbFilter $filter Объект фильтра
     * @return bool
     */
    final public function find($filter = false)
    {
        $sql = QueryBuilder::find($this, $filter);

        $result = Db::getRow($sql);

        if (empty($result)) {
            return false;
        }

        $this->setProperties($result);

        return true;
    }

    /**
     * Произвольный запрос с постраничным выводом
     * @param string $sql Запрос
     * @param bool|DbPaginator $pager Объект постраничного вывода
     * @return array|bool
     */
    final protected function query($sql, $pager = false)
    {
        $pager && $sql = QueryBuilder::setPage($sql, $pager);

        $result = Db::getRows($sql);

        if (empty($result)) {
            return false;
        }

        $pager && $pager->calcMaxPages();

        return $result;
    }
}
