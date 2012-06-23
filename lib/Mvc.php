<?php
/**
 * Класс реализующий MVC-архитектуру проекта
 * @file    Mvc.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 18:10:37 2012
 * @version
 */

/**
 * Класс Mvc
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Mvc
{
    /**
     * Старт приложения
     */
    final public static function run()
    {
        self::setPhpSettings();
        // Получаем имя контроллера и метода

        $controller = Route::getController();
        $action     = Route::getAction();

        // Запускаем контроллер
        //$variables  = $controller->$action();

        // Инициализируем переменные во view
        /*$view = new View();
        $view->set($variables);

        // Запускаем view
        $view->show();*/
    }

    /**
     * Устанавливаем настройки php, прописанные в конфиге
     */
    private static function setPhpSettings()
    {
        if (NULL === ($settings = Config::getParams('php')))
            return;

        foreach ($settings as $param => $value) {
            ini_set($param, $value);
        }
    }
}
