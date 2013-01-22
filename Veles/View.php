<?php
/**
 * Класс вывода
 * @file    View.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 07 07:30:30 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use \Veles\Routing\Route;
use \Exception;

/**
 * Класс View
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class View
{
    private static $variables = array();

    /**
     * Метод для установки переменных в выводе
     * @param array $vars Массив переменных для вывода
     * @throws Exception
     */
    final public static function set($vars)
    {
        if (!is_array($vars)) {
            throw new Exception('View can set variables only in arrays!');
        }

        self::$variables = array_merge(self::$variables, $vars);
    }

    /**
     * Метод вывода
     * @param string $path Путь к шаблону
     */
    final public static function show($path)
    {
        foreach (self::$variables as $var_name => $value) {
            $$var_name = $value;
        }

        ob_start();
        require TEMPLATE_PATH . $path;
        ob_end_flush();
    }

    /**
     * Вывод View в буфер и сохранение в переменную
     * @param string $path Путь к шаблону
     * @return string Вывод View
     */
    final public static function get($path)
    {
        foreach (self::$variables as $var_name => $value) {
            $$var_name = $value;
        }

        ob_start();
        require TEMPLATE_PATH . $path;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
