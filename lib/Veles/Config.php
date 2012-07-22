<?php
/**
 * Класс-парсер конфигурации проекта
 * @file    Config.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 17:28:22 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles;

use \Exception;

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
        $tmp_config = parse_ini_file(CONFIG_FILE, true);

        self::initInheritance($tmp_config);

        if (!isset($tmp_config[ENVIRONMENT])) {
            throw new Exception('Не найдена секция окружения в конфиг-файле!');
        }

        self::$data = $tmp_config[ENVIRONMENT];

        unset($tmp_config);

        self::buildPramsTree(self::$data);
    }

    /**
     * Построение массива параметров
     * @param array &$config
     */
    private static function buildPramsTree(&$config)
    {
        foreach ($config as $name => $value) {
            $params = explode('.', $name);

            if (1 === count($params))
                continue;

            $ptr =& $config;

            foreach ($params as $param) {
                if ($param === end($params))
                    $ptr[$param] = $value;
                else
                    $ptr =& $ptr[$param];
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
        foreach ($config as $namespace => $param) {
            $section = explode(':', $namespace);

            array_walk($section, function(&$value) {
                $value = trim($value);
            });

            // Обработка наследования параметров только для секции окружения
            if (ENVIRONMENT !== $section[0]
                || !isset($section[1])
                || !isset($config[$section[1]])
            ) {
                continue;
            }

            $config[ENVIRONMENT] = array_merge($config[$section[1]], $config[$namespace]);
        }
    }

    /**
     * Проверка умолчаний окружения и пути
     */
    private static function checkDefaults()
    {
        if (null === ENVIRONMENT)
            define('ENVIRONMENT', 'production');

        if (null === CONFIG_FILE)
            define('CONFIG_PATH', realpath('../project/settings.ini'));
    }

    /**
     * Получение параметров конфиг-файла
     * @param string $param
     * @return mixed
     */
    final public static function getParams($param)
    {
        if (null === self::$data)
            self::read();

        return isset(self::$data[$param]) ? self::$data[$param] : null;
    }
}
