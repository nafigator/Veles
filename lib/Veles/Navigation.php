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
    private $menu_items      = NULL;
    private $config          = NULL;
    private $breadcrumbs     = NULL;
    private static $instance = NULL;

    /**
     * Доступ к объекту
     * @return Navigation
     */
    final public static function instance()
    {
        if (NULL === self::$instance)
            self::$instance = new Navigation();

        return self::$instance;
    }

    /**
     * Создание дерева-массива меню и хлебных крошек
     * @param string $page_name
     */
    private function __construct()
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
        if (NULL !== $this->menu_items)
            return $this->menu_items;

        //$this->menu_items = array_walk_recursive();
    }

    /**
     * Получение массива хлебных крошек
     * @return array
     */
    final public function getBreadCrumbs()
    {

    }
}
