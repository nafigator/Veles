<?php
/**
 * Интерфейс для стратегий роутинга
 * @file    iRouteStrategy.php
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 10:06:37 2012
 * @version
 */

/**
 * Класс iRouteStrategy
 * @author  Yancharuk Alexander <alex@itvault.info>
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
