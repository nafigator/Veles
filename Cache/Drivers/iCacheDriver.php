<?php
/**
 * Интерфейс кэша
 * @file    iCacheDriver.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Ноя 15 21:36:22 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Drivers;

/**
 * Интерфейс iCacheDriver
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iCacheDriver
{
	/**
	 * Получение данных
	 * @param string $key Ключ
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Сохранение данных
	 * @param string $key Ключ
	 * @param mixed $value Данные
	 * @return bool
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
