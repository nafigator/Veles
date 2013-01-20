<?php
/**
 * Класс-парсер конфигурации проекта
 * @file    Config.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 17:28:22 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use \Exception;
use \Cache;

/**
 * Класс Config
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Config
{
    private static $data = null;

    /**
     * Парсер конфиг файла
     * @throws Exception
     */
    private static function read()
    {
        self::checkDefaults();

        if (Cache::has('config')) {
            self::$data = Cache::get('config');
            return;
        }

        $tmp_config = parse_ini_file(CONFIG_FILE, true);

        self::initInheritance($tmp_config);

        if (!isset($tmp_config[ENVIRONMENT])) {
            throw new Exception('Не найдена секция окружения в конфиг-файле!');
        }

        self::$data = $tmp_config[ENVIRONMENT];

        unset($tmp_config);

        self::buildPramsTree(self::$data);
        Cache::set('config', self::$data);
    }

    /**
     * Построение массива параметров
     * @param array &$config
     */
    private static function buildPramsTree(&$config)
    {
        foreach ($config as $name => $value) {
            $params = explode('.', $name);

            if (1 === count($params)) {
                continue;
            }

            $ptr =& $config;

            foreach ($params as $param) {
                if ($param === end($params)) {
                    $ptr[$param] = $value;
                } else {
                    $ptr =& $ptr[$param];
                }
            }

            unset($config[$name]);
        }
    }

    /**
     * Наследование секций конфига
     * @param array $config
     */
    private static function initInheritance(&$config)
    {
        $namespaces = array_keys($config);
        foreach ($namespaces as $namespace) {
            $section = explode(':', $namespace);

            $closure = function (&$value) {
                $value = trim($value);
            };

            array_walk($section, $closure);

            // Обработка наследования параметров только для секции окружения
            if (ENVIRONMENT !== $section[0]
                || !isset($section[1])
                || !isset($config[$section[1]])
            ) {
                continue;
            }

            $config[ENVIRONMENT] = array_merge(
                $config[$section[1]], $config[$namespace]
            );
        }
    }

    /**
     * Проверка умолчаний окружения и пути
     */
    private static function checkDefaults()
    {
        if (null === ENVIRONMENT) {
            define('ENVIRONMENT', 'production');
        }

        if (null === CONFIG_FILE) {
            define('CONFIG_PATH', realpath('../project/settings.ini'));
        }
    }

    /**
     * Получение параметров конфиг-файла
     * @param string $param
     * @return mixed
     */
    final public static function getParams($param)
    {
        if (null === self::$data) {
            self::read();
        }

        $param_arr = explode('.', $param);

        $ptr =& self::$data;
        foreach ($param_arr as $param_element) {
            if (isset($ptr[$param_element])) {
                $ptr =& $ptr[$param_element];
            } else {
                return null;
            }
        }

        return $ptr;
    }
}
