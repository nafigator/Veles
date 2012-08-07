<?php
/**
 * Фильтр для выборки моделей
 * @file    AbstractFilter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 07 23:14:17 2012
 * @version
 */

namespace Veles\DstaBase;
/**
 * Класс AbstractFilter
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractFilter
{
    protected $conditions = array();

    /**
     * Метод для получения значений фильтра
     */
    abstract public function getConditions();
}
