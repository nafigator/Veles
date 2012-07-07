<?php
/**
 * Класс вывода
 * @file    View.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 07:30:30 2012
 * @version
 */

namespace Veles;

use Veles\Routing\Route;

/**
 * Класс View
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class View
{
    private static $variables = array();
    private static $route     = null;

    /**
     * Метод для установки переменных в выводе
     * @param array $vars Массив переменных для вывода
     */
    final public static function set($vars)
    {
        self::$variables = array_merge(self::$variables, (array) $vars);
    }

    /**
     * Метод вывода
     * @param string $page_name Имя странички
     * @param string $tpl_name Имя шаблона
     */
    final public static function show($page_name, $tpl_name)
    {
        foreach (self::$variables as $var_name => $value) {
            $$var_name = $value;
        }

        $template_name = implode(
            DIRECTORY_SEPARATOR,
            array(TEMPLATE_PATH, $page_name, $tpl_name . '.tpl')
        );

        require $template_name;
    }
}
