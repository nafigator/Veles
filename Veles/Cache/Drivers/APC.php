<?php
/**
 * Драйвер для APC кэша
 * @file    APC.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Ноя 16 22:09:28 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Drivers;

use \Exception;

/**
 * Класс APC
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class APC implements iCacheDriver
{
    /**
     * Конструктор
     */
    final public function __construct()
    {
        if (!function_exists('apc_add')) {
            throw new Exception('Кэш APC не установлен!');
        }
    }

    /**
     * Получение данных
     * @param string $key Ключ
     * @return mixed
     */
    public function get($key)
    {
        return apc_fetch($key);
    }

    /**
     * Сохранение данных
     * @param string $key Ключ
     * @param mixed $value Данные
     * @param int $ttl Время хранения данных в секундах
     * @return mixed
     */
    public function set($key, $value, $ttl = 0)
    {
        return apc_add($key, $value, $ttl);
    }

    /**
     * Проверка существуют ли данные в кэше
     * @param string $key Ключ
     * @return bool
     */
    public function has($key)
    {
        apc_exists($key);
    }

    /**
     * Удаление данных
     * @param string $key Ключ
     * @return bool
     */
    public function del($key)
    {
        return apc_delete($key);
    }

    /**
     * Очистка кэша
     * @return bool
     */
    public function clear()
    {
        return apc_clear_cache();
    }
}
