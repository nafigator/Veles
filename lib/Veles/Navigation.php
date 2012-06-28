<?php
/**
 * Класс навигации
 * @file    Navigation.php
 *
 * PHP version 5.3.9
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Июн 27 22:17:23 2012
 * @version
 */

namespace Veles;

/**
 * Класс Navigation
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Navigation
{
    private $menu            = NULL;
    private $config          = NULL;
    private $breadcrumbs     = NULL;
    private static $instance = NULL;

    /**
     * Доступ к объекту
     * @return Navigation
     */
    final public static function instance($page_name)
    {
        if (NULL === self::$instance)
            self::$instance = new Navigation($page_name);

        return self::$instance;
    }

    /**
     * Создание дерева-массива меню и хлебных крошек
     * @param string $page_name
     */
    private function __construct($page_name)
    {
        if (NULL === ($config = Config::getParams('navigation'))) {
            throw new Exception("В конфиге не найдена навигация!");
        }
    }

    /**
     * Получение массива меню
     * @return array
     */
    final public function getMenuItems()
    {

    }

    /**
     * Получение массива хлебных крошек
     * @return array
     */
    final public function getBreadCrumbs()
    {

    }
}
