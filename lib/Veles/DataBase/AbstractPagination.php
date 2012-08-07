<?php
/**
 * Абстрактный класс для постраничного вывода
 * @file    AbstractPagination.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 07 23:04:47 2012
 * @version
 */

namespace Veles\DataBase;

/**
 * Класс AbstractPagination
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractPagination
{
    protected $offset = 0;
    protected $limit  = 5;

    /**
     * Метод получения offset
     */
    abstract public function getOffset();

    /**
     * Метод получения limit
     */
    abstract public function getLimit();
}
