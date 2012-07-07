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
/**
 * Класс View
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class View
{
    private static $variables;
    private static $page_name;

    /**
     * Метод для установки переменных в выводе
     * @param array $vars Массив переменных для вывода
     */
    final public static function set($name, $vars)
    {
        self::$page_name = is_string($name) ? $name : (string) $name;
        self::$variables = is_array($vars)  ? $vars : (array)  $vars;
    }

    /**
     * Метод вывода
     */
    final public static function show()
    {
        foreach (self::$variables as $var_name => $value) {
            $$var_name = $value;
        }

        $template_name = implode(
            DIRECTORY_SEPARATOR,
            array(TEMPLATE_PATH, self::$page_name, 'index.tpl')
        );

        require $template_name;
    }
}
