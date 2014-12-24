<?php
/**
 * @file    travisci-bootstrap.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-12-24 09:59
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
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;
use Veles\DataBase\Db;
use PDO;

define('ENVIRONMENT', 'development');
define('LIB_DIR', realpath(__DIR__ . '/../..'));
define('TEST_DIR', realpath(LIB_DIR . '/Veles/Tests'));
define('CONFIG_FILE', TEST_DIR . '/Project/settings.ini');
define('TEMPLATE_PATH', TEST_DIR . '/Project/View/');

date_default_timezone_set('Europe/Moscow');

require LIB_DIR . '/Veles/AutoLoader.php';
AutoLoader::init();
AutoLoader::registerPath(
	[LIB_DIR, TEST_DIR, realpath(__DIR__ . '/Project')]
);

$view_adapter = new NativeAdapter;
$view_adapter->setTemplateDir(TEST_DIR . '/Project/View/');
View::setAdapter($view_adapter);

// Cache initialization
MemcacheRaw::setConnectionParams('localhost', 11211);
MemcachedAdapter::addCall('addServer', ['localhost', 11211]);
MemcacheAdapter::addCall('addServer', ['localhost', 11211]);
Cache::setAdapter(MemcachedAdapter::instance());

// Parameters for Db connection
$pool = new ConnectionPool();
$conn = new PdoConnection('master');

// Database "test" must be created
$conn->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('travis')
	->setPassword('')
	->setOptions([PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

$pool->addConnection($conn, true);
PdoAdapter::setPool($pool);

Db::setAdapter(PdoAdapter::instance());
