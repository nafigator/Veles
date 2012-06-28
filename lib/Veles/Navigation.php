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
    private static $menu;
    private static $breadcrumbs;

    /**
     * Создание дерева-массива меню и хлебных крошек
     * @param string $page_name
     */
    final public static function init($page_name)
    {
        $config = Config::getParams('routes');

        /*self::$menu        = self::buildMenu();
        self::$breadcrumbs = self::buildBreadCrumbs();*/
    }
}
