<?php
/**
 * Класс роутинга
 * @file    Route.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июн 23 08:52:41 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

use \Veles\Config;
use \Exception;

/**
 * Класс Route
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Route
{
    private static $instance = null;
    private $page_name       = null;
    private $config          = null;
    private $template        = null;
    private $map             = array();

    /**
     * Доступ к объекту
     * @return Route
     */
    final public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new Route;
        }

        return self::$instance;
    }

    /**
     * Парсинг конфига и инициализация переменных контроллера и экшена
     * @throws Exception
     */
    private function __construct()
    {
        if (null === ($routes = Config::getParams('routes'))) {
            throw new Exception('В конфиге не найдены роуты!');
        }

        $q_pos = strpos($_SERVER['REQUEST_URI'], '?');

        $url = ($q_pos)
            ? urldecode(substr($_SERVER['REQUEST_URI'], 0, $q_pos))
            : urldecode($_SERVER['REQUEST_URI']);

        foreach ($routes as $name => $route) {
            if (!$route['class']::check($route['route'], $url)) {
                continue;
            }

            $this->config    = $route;
            $this->page_name = $name;

            if (isset($route['tpl'])) {
                $this->template = $route['tpl'];
            }

            $this->checkAjax();

            if (isset($route['map'])
                && null !== ($map = $route['class']::getMap())
            ) {
                $this->map = array_combine($route['map'], $map);
            }

            return;
        }

        Route404::show($url);
    }

    /**
     * Получение и инициализация контроллера
     * @throws Exception
     * @return object
     */
    final public function getController()
    {
        if (!isset($this->config['controller'])) {
            throw new Exception('Не указан контроллер!');
        }

        $controller_name = 'Controllers\\' . $this->config['controller'];

        return new $controller_name;
    }

    /**
     * Получение имени метода
     * @throws Exception
     * @return string
     */
    final public function getActionName()
    {
        if (!isset($this->config['action'])) {
            throw new Exception('Не указан экшен!');
        }

        return $this->config['action'];
    }

    /**
     * Получение ajax-флага
     * @throws Exception
     * @return string
     */
    final public function isAjax()
    {
        return isset($this->config['ajax']) ? $this->config['ajax'] : false;
    }

    /**
     * Получение имени страницы
     * @throws Exception
     * @return string
     */
    final public function getPageName()
    {
        if (!isset($this->page_name)) {
            throw new Exception('Не найдено имя страницы!');
        }

        return $this->page_name;
    }

    /**
     * Получение URL-параметров
     * @return array
     */
    final public function getMap()
    {
        return $this->map;
    }

    /**
     * Получение пути к view-шаблону
     */
    final public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Проверка является запрос AJAX-запросом
     */
    private function checkAjax()
    {
        if (!$this->isAjax()) {
            return;
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH']
        ) {
            return;
        }

        throw new Exception('На AJAX-роут отправлен не ajax-запрос!');
    }
}
