<?php
/**
 * Класс-парсер конфигурации проекта
 * @file    Config.php
 *
 * PHP version 5.3+
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
        $config = parse_ini_file(CONFIG_FILE, TRUE);

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

        try {
            if (!isset($config[ENVIRONMENT])) {
                throw new Exception('Не найдена секция окружения в конфиг-файле!');
            }

            self::$data = $config[ENVIRONMENT];
        }
        catch(Exception $e) {
            //TODO: Редирект на 500
            die($e->getMessage());
        }

        unset($config);
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
     * @param string $category
     * @param string $param
     * @return mixed
     */
    final public static function getParams ($param)
    {
        if (NULL === self::$data)
            self::read();

        return (isset(self::$data[$param])) ? self::$data[$param] : NULL;
    }
}
