<?php
/**
 * Файл-инициализатор проекта
 * @file    index.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 08:19:06 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

use \Veles\Error,
    \Veles\AutoLoader,
    \Veles\Application;

// окружение: development, production
define('ENVIRONMENT', 'development');
define('BASE_PATH', realpath('..') . DIRECTORY_SEPARATOR);
define('CONFIG_FILE', BASE_PATH . 'project/settings.ini');
define('TEMPLATE_PATH', BASE_PATH . 'project/View');

set_include_path(implode(PATH_SEPARATOR,
    array(realpath('../project'), realpath('../lib'), get_include_path())
));

setlocale(LC_ALL, 'ru_RU.utf8');

require 'Veles/AutoLoader.php';
AutoLoader::init();

$error = new Error;
register_shutdown_function(array($error, 'fatal'));
set_error_handler(array($error, 'error'));
set_exception_handler(array($error, 'exception'));

Application::run();
