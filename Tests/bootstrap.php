<?php
/**
 * Environment initialisation for unit-tests
 *
 * Launch test in root directory:
 * phpunit
 * Unit-tests skeletons generation:
 * phpunit-skelgen --test -- "Veles\Helper" Helper.php HelperTest Tests/HelperTest.php
 * phpunit-skelgen --test -- "Veles\Tools\File" Tools/File.php "Veles\Tests\Tools\FileTest" Tests/Tools/FileTest.php
 *
 * @file    bootstrap.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Чтв Дек 20 12:22:58 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests;

use Veles\AutoLoader;

define('ENVIRONMENT', 'development');
define('LIB_DIR', realpath(__DIR__ . '/../..'));
define('TEST_DIR', realpath(LIB_DIR . '/Veles/Tests'));
define('CONFIG_FILE', TEST_DIR . '/Project/settings.ini');
define('TEMPLATE_PATH', TEST_DIR . '/Project/View/');

set_include_path(implode(PATH_SEPARATOR, array(
	LIB_DIR,
	TEST_DIR,
	realpath(__DIR__ . '/Project'),
	get_include_path()
)));

/** @noinspection PhpIncludeInspection */
require 'Veles/AutoLoader.php';
AutoLoader::init();
