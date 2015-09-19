<?php
/**
 * Environment initialisation for unit-tests
 *
 * Launch test in root directory:
 * phpunit
 * Unit-tests skeletons generation:
 * phpunit-skelgen --bootstrap="Tests/bootstrap.php" generate-test "Veles\Cache\Adapters\ApcAdapter" "Cache\Adapters\ApcAdapter.php" "Veles\Tests\Cache\Adapters\ApcAdapterTest" "Tests/Cache/Adapters/ApcAdapterTest.php"
 *
 * @file      bootstrap.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Чтв Дек 20 12:22:58 2012
 * @license The BSD 3-Clause License <http://opensource.org/licenses/BSD-3-Clause>
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
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;
use Veles\View\Adapters\NativeAdapter;
use Veles\View\View;

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 'STDOUT');
ini_set('display_startup_errors', true);

define('LIB_DIR', realpath(__DIR__ . '/../..'));
define('TEST_DIR', realpath(LIB_DIR . '/Veles/Tests'));

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
$conn1 = new PdoConnection('master');

// Database "test" must be created
$conn1->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('user')
	->setPassword('password')
	->setOptions([
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=ANSI'
	]);

// For testing exceptions thrown on connection errors
$conn2 = new PdoConnection('fake');
$conn2->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('user')
	->setPassword('password')
	->setOptions([
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);

$pool->addConnection($conn1, true);
$pool->addConnection($conn2);
PdoAdapter::setPool($pool);

$routes_loader = new IniConfigLoader(TEST_DIR . '/Project/routes.ini');
Route::setConfigHandler(new RoutesConfig($routes_loader));

Db::setAdapter(PdoAdapter::instance());
system('mysql -u user -p password -e "DROP DATABASE IF EXISTS test; CREATE DATABASE IF NOT EXISTS test DEFAULT CHARACTER SET utf8"');
register_shutdown_function(function() { Db::query('DROP DATABASE test'); });
