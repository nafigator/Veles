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

use \Veles\AutoLoader,
    \Veles\CurrentUser,
    \Veles\Application,
    \Veles\DataBase\Db;

// окружение: development, production
define('ENVIRONMENT', 'development');
define('CONFIG_FILE', realpath('../project/settings.ini'));
define('TEMPLATE_PATH', realpath('../project/View'));

set_include_path(implode(PATH_SEPARATOR,
    array(realpath('../project'), realpath('../lib'), get_include_path())
));


require('Veles/AutoLoader.php');
AutoLoader::init();

Application::run();
