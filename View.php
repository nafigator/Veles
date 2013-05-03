<?php
/**
 * Output class
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
 * ClassView
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class View
{
    private static $variables = array();

    /**
     * Method for output variables setup
     *
     * @param array $vars Output variables array
     * @throws Exception
     */
    final public static function set($vars)
    {
        if (!is_array($vars)) {
            throw new Exception('View can set variables only in arrays!');
        }

        self::$variables = array_replace(self::$variables, $vars);
    }

    /**
     * Output variables cleanup
     *
     * @param array $vars Массив имён переменных для очистки
     * @throws Exception
     */
    final public static function del($vars)
    {
        if (!is_array($vars)) {
            throw new Exception('View can unset variables only in arrays!');
        }

        foreach ($vars as $var_name) {
            if (isset(self::$variables[$var_name])) {
                unset(self::$variables[$var_name]);
            }
        }
    }

    /**
     * Output method
     *
     * @param string $path Путь к шаблону
     */
    final public static function show($path)
    {
        foreach (self::$variables as $var_name => $value) {
            $$var_name = $value;
        }

        ob_start();
        /** @noinspection PhpIncludeInspection */
        require TEMPLATE_PATH . $path;
        ob_end_flush();
    }

    /**
     * Output View into buffer and save it in variable
     *
     * @param string $path Path to template
     * @return string View content
     */
    final public static function get($path)
    {
        foreach (self::$variables as $var_name => $value) {
            $$var_name = $value;
        }

        ob_start();
        /** @noinspection PhpIncludeInspection */
        require TEMPLATE_PATH . $path;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
