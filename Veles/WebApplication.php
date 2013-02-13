<?php
/**
 * Класс реализующий MVC-архитектуру проекта
 * @file    WebApplication.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 18:10:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use \Veles\Routing\Route;
use \Veles\Auth\UsrAuth;
use \Veles\ErrorHandler\ErrBase;

/**
 * Класс Application
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class WebApplication
{
    /**
     * Старт приложения
     */
    public static function run()
    {
        self::setPhpSettings();
        self::setErrorHandlers();

        UsrAuth::instance();

        // Получаем имя контроллера и метода
        $route       = Route::instance();
        $controller  = $route->getController();
        $action_name = $route->getActionName();
        $template    = $route->getTemplate();

        View::set($controller->$action_name());

        View::show($template);
    }

    /**
     * Инициализируем ErrorHandlers
     */
    protected static function setErrorHandlers()
    {
        $error = new ErrBase;
        register_shutdown_function(array($error, 'fatal'));
        set_error_handler(array($error, 'usrError'));
        set_exception_handler(array($error, 'exception'));
    }

    /**
     * Устанавливаем настройки php, прописанные в конфиге
     * @todo Описать параметры
     */
    protected static function setPhpSettings($keys = null)
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
