<?php
/**
 * Класс реализующий MVC-архитектуру проекта
 * @file    Application.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 18:10:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use \Veles\Routing\Route;

/**
 * Класс Application
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Application
{
    /**
     * Старт приложения
     */
    final public static function run()
    {
        self::setPhpSettings();

        UsrAuth::instance();

        // Получаем имя контроллера и метода
        $route       = Route::instance();
        $controller  = $route->getController();
        $action_name = $route->getActionName();
        $path        = $route->getPath();

        View::set($controller->$action_name());

        View::show($path);
    }

    /**
     * Устанавливаем настройки php, прописанные в конфиге
     * @todo Описать параметры
     */
    private static function setPhpSettings($keys = null)
    {
        $config = (null === $keys)
            ? Config::getParams('php')
            : $keys;

        if (null === $config) {
            return;
        }

        foreach ($config as $param => $value) {
            if (is_array($value)) {
                self::setPhpSettings($value);
                continue;
            }

            ini_set($param, $value);
        }
    }
}
