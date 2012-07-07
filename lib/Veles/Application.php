<?php
/**
 * Класс реализующий MVC-архитектуру проекта
 * @file    Application.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 18:10:37 2012
 * @version
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

        CurrentUser::instance();

        // Получаем имя контроллера и метода
        $route       = Route::instance();
        $controller  = $route->getController();
        $action_name = $route->getAction();
        $page_name   = $route->getPageName();

        if (!$route->isAjax()) {
            Navigation::instance($route->getPageName());
        }

        // Запускаем контроллер
        $variables = $controller->$action_name();

        // Инициализируем переменные во view
        View::set($variables);

        // Запускаем view
        View::show($page_name, $action_name);
    }

    /**
     * Устанавливаем настройки php, прописанные в конфиге
     */
    private static function setPhpSettings()
    {
        if (null === ($settings = Config::getParams('php')))
            return;

        foreach ($settings as $param => $value) {
            ini_set($param, $value);
        }
    }
}
