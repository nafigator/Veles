<?php
/**
 * Инициализация окружения для тестирования
 *
 * Запускать тесты в директории lib или lib/Veles:
 * phpunit
 * Генерировать скелеты тестов в lib/Veles так:
 * phpunit-skelgen --test -- "Veles\Helper" Helper.php HelperTest Tests/HelperTest.php
 *
 * @file    bootstrap.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Дек 20 12:22:58 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

set_include_path(implode(PATH_SEPARATOR,
    array(realpath('../'), get_include_path())
));

require 'Veles/AutoLoader.php';
AutoLoader::init();
