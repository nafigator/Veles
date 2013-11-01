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
use Veles\Cache\Cache;
use Veles\Cache\Adapters\MemcacheRaw;
use Veles\Cache\Adapters\MemcacheAdapter;
use Veles\Cache\Adapters\MemcachedAdapter;
use Veles\View\Adapters\NativeAdapter;
use Veles\View\View;

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

date_default_timezone_set('Europe/Moscow');
/** @noinspection PhpIncludeInspection */
include 'Veles/AutoLoader.php';
AutoLoader::init();

NativeAdapter::instance()->setTemplateDir(TEST_DIR . '/Project/View/');
View::setAdapter('Native');

// Cache initialization
MemcacheRaw::setConnectionParams('localhost', 11211);
MemcachedAdapter::instance()->addServer('localhost', 11211);
MemcacheAdapter::instance()->addServer('localhost', 11211);
Cache::setAdapter('Memcached');