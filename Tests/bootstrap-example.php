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

use PDO;
use Veles\AutoLoader;
use Veles\Cache\Adapters\MemcacheAdapter;
use Veles\Cache\Adapters\MemcachedAdapter;
use Veles\Cache\Adapters\MemcacheRaw;
use Veles\Cache\Cache;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;
use Veles\DataBase\Db;
use Veles\View\Adapters\NativeAdapter;
use Veles\View\View;

define('ENVIRONMENT', 'development');
define('LIB_DIR', realpath(__DIR__ . '/../..'));
define('TEST_DIR', realpath(LIB_DIR . '/Veles/Tests'));
define('CONFIG_FILE', TEST_DIR . '/Project/settings.ini');
define('TEMPLATE_PATH', TEST_DIR . '/Project/View/');

date_default_timezone_set('Europe/Moscow');

require LIB_DIR . '/Veles/AutoLoader.php';
AutoLoader::init();
AutoLoader::registerPath(
	array(LIB_DIR, TEST_DIR, realpath(__DIR__ . '/Project'))
);

NativeAdapter::instance()->setTemplateDir(TEST_DIR . '/Project/View/');
View::setAdapter(NativeAdapter::instance());

// Cache initialization
MemcacheRaw::setConnectionParams('localhost', 11211);
MemcachedAdapter::addCall('addServer', array('localhost', 11211));
MemcacheAdapter::addCall('addServer', array('localhost', 11211));
Cache::setAdapter('Memcached');

// Parameters for Db connection
$pool = new ConnectionPool();
$conn = new PdoConnection('master');

// Database "test" must be created
$conn->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('user')
	->setPassword('password');
$pool->addConnection($conn, true);
PdoAdapter::setPool($pool);
PdoAdapter::addCall(
	'setAttribute',
	array(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC)
);
Db::setAdapter('Pdo');
