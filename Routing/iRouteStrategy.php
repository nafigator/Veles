<?php
/**
 * Интерфейс для стратегий роутинга
 * @file    iRouteStrategy.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Сбт Июн 23 10:06:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Класс iRouteStrategy
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
interface iRouteStrategy
{
	/**
	 * Метод для проверки текущего url на соответствие шаблонам роутов из конфига
	 * @param string $url
	 * @param string $pattern
	 * @return bool
	 */
	public static function check($url, $pattern);
}
