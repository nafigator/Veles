<?php
/**
 * Класс навигации
 * @file    Navigation.php
 *
 * PHP version 5.3.9
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Июн 27 22:17:23 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles;

/**
 * Класс Navigation
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Navigation
{
    private $menu_items      = null;
    private $config          = null;
    private $breadcrumbs     = null;
    private static $instance = null;

    /**
     * Доступ к объекту
     * @return Navigation
     */
    final public static function instance()
    {
        if (null === self::$instance)
            self::$instance = new Navigation();

        return self::$instance;
    }

    /**
     * Создание дерева-массива меню и хлебных крошек
     * @param string $page_name
     */
    private function __construct()
    {
        if (null === ($config = Config::getParams('navigation'))) {
            throw new Exception('В конфиге не найдена навигация!');
        }
    }

    /**
     * Получение массива меню
     * @return array
     */
    final public function getMenuItems()
    {
        if (null !== $this->menu_items)
            return $this->menu_items;

        //$this->menu_items = array_walk_recursive();
    }

    /**
     * Получение массива хлебных крошек
     * @return array
     */
    final public function getBreadCrumbs()
    {
        return $this->breadcrumbs;
    }
}
