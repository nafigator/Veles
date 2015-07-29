<?php
/**
 * @file      travisci-nightly-bootstrap.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-07-29 21:59
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests;

use PDO;
use Veles\AutoLoader;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;
use Veles\DataBase\Db;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;
use Veles\View\Adapters\NativeAdapter;
use Veles\View\View;

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

// Parameters for Db connection
$pool = new ConnectionPool();
$conn1 = new PdoConnection('master');

// Database "test" must be created
$conn1->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('travis')
	->setPassword('')
	->setOptions([
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);

// For testing exceptions thrown on connection errors
$conn2 = new PdoConnection('fake');
$conn2->setDsn('mysql:host=localhost;dbname=test;charset=utf8')
	->setUserName('fake-user')
	->setPassword('fake-password')
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
