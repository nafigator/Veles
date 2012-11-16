<?php
/**
 * Интерфейс кэша
 * @file    iCache.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Ноя 15 21:36:22 2012
 * @version
 */

namespace Veles\Cache;

/**
 * Интерфейс iCache
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iCache
{
    /**
     * Получение данных
     * @param string $key Ключ
     * @return mixed
     */
    public function get($key);

    /**
     * Сохранение данных
     * @param stirng $key Ключ
     * @param mixed $value Данные
     */
    public function set($key, $value);

    /**
     * Проверка существуют ли данные в кэше
     * @param string $key Ключ
     * @return bool
     */
    public function has($key);

    /**
     * Удаление данных
     * @param string $key Ключ
     * @return bool
     */
    public function del($key);

    /**
     * Очистка кэша
     * @return bool
     */
    public function clear();
}
