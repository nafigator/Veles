<?php
/**
 * Инициализация окружения для тестирования
 *
 * Запускать тесты в директории lib/Veles:
 * phpunit --bootstrap Tests/bootstrap.php Tests
 * Генерировать скелеты тестов так:
 * phpunit-skelgen --test -- "Veles\Helper" Helper.php HelperTest Tests/HelperTest.php
 *
 * @file    bootstrap.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Дек 20 12:22:58 2012
 * @version
 */

namespace Veles;

set_include_path(implode(PATH_SEPARATOR,
    array(realpath('../'), get_include_path())
));

require 'Veles/AutoLoader.php';
AutoLoader::init();
