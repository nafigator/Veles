<?php
/**
 * Класс-парсер конфигурации проекта
 * @file    Config.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 17:28:22 2012
 * @version
 */

/**
 * Класс Config
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Config
{
    private static $data = NULL;

    /**
     * Парсер конфиг файла
     * @throws Exception
     */
    private static function read()
    {
        self::checkDefaults();
        $tmp_config = parse_ini_file(CONFIG_FILE, TRUE);

        self::initInheritance($tmp_config);

        try {
            if (!isset($tmp_config[ENVIRONMENT])) {
                throw new Exception('Не найдена секция окружения в конфиг-файле!');
            }

            self::$data = $tmp_config[ENVIRONMENT];
        }
        catch(Exception $e) {
            //TODO: Редирект на 500
            die($e->getMessage());
        }

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
                if ($param !== end($params))
                    $ptr =& $ptr[$param];
                else
                    $ptr[$param] = $value;
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
        if (NULL === ENVIRONMENT)
            define('ENVIRONMENT', 'production');

        if (NULL === CONFIG_FILE)
            define('CONFIG_PATH', realpath('../project/settings.ini'));
    }

    /**
     * Получение параметров конфиг-файла
     * @param string $param
     * @return mixed
     */
    final public static function getParams($param)
    {
        if (NULL === self::$data) self::read();

        return isset(self::$data[$param]) ? self::$data[$param] : NULL;
    }
}
