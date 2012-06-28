<?php
/**
 * Класс роутинга
 * @file    Route.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 08:52:41 2012
 * @version
 */

namespace Veles\Routing;

use \Veles\Config,
    \Exception;

/**
 * Класс Route
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Route
{
    private static $instance   = NULL;
    private $page_name         = NULL;
    private $config            = NULL;

    /**
     * Доступ к объекту
     * @return Route
     */
    final public static function getInstance()
    {
        if (NULL === self::$instance)
            self::$instance = new Route();

        return self::$instance;
    }

    /**
     * Парсинг конфига и инициализация переменных контроллера и экшена
     * @throws Exception
     */
    private function __construct()
    {
        $routes = Config::getParams('routes');
        $q_pos  = strpos($_SERVER['REQUEST_URI'], '?');

        $url = ($q_pos)
            ? substr($_SERVER['REQUEST_URI'], 0, $q_pos)
            : $_SERVER['REQUEST_URI'];

        foreach ($routes as $name => $route) {
            if ($route['class']::check($route['route'], $url)) {
                $this->config    = $route;
                $this->page_name = $name;
                return;
            }
        }

        //TODO: go to 404!
        throw new Exception("URL $url не найден в конфиге роутинга!");
    }

    /**
     * Получение и инициалзация контроллера
     * @throws Exception
     * @return object
     */
    final public function getController()
    {
        if (!isset($this->config['controller']))
            throw new Exception("Не указан контроллер!");

        //TODO: new self::$config['controller'];
        return $this->config['controller'];
    }

    /**
     * Получение имени метода
     * @throws Exception
     * @return string
     */
    final public function getAction()
    {
        if (!isset($this->config['action']))
            throw new Exception("Не указан экшен!");

        return $this->config['action'];
    }

    /**
     * Получение ajax-флага
     * @throws Exception
     * @return string
     */
    final public function isAjax()
    {
        return isset($this->config['ajax']) ? $this->config['ajax'] : FALSE;
    }

    /**
     * Получение имени страницы
     * @throws Exception
     * @return string
     */
    final public function getPageName()
    {
        if (!isset($this->page_name))
            throw new Exception("Не найдено имя страницы!");

        return $this->page_name;
    }
}
