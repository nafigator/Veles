<?php

//require_once 'includes/db_connect.inc';
//require_once 'includes/UserTables.class.inc';

define('DEBUG', TRUE);

set_include_path(implode(PATH_SEPARATOR,
    array(realpath('../lib'), get_include_path())
));

set_include_path(implode(PATH_SEPARATOR,
    array(realpath('../project'), get_include_path())
));
//var_dump(get_include_path());
require('AutoLoader.php');
AutoLoader::init();

//$user_tables = new UserTables();

//$user_tables->create();

//$user_tables->drop();



$user = new User;
var_dump('$user->auth()', $user->auth());

var_dump('$user', $user);

var_dump(
    'in group 8,3,2: ', $user->hasAccess(array(8,3,2)),
    'Debug data: ', Db::getErrors()
);

$user->group = 18;
$user->save();
/*$time = $stop = 0;

for ($i = 0; $i < 10000; ++$i) {
    $start = xdebug_time_index();
    $string = Helper::genStr();
    $stop = xdebug_time_index() - $start;
    (float)$time += (float) $stop;
    //echo '<br>', '*** ', $stop, ' ***';
} echo $string;
echo '<br>Среднее время Helper::genStr(): ', (float)$time / (float)10000;*/

/*$time1 = $stop = 0;

for ($i = 0; $i < 10000; ++$i) {
    $start = xdebug_time_index();
    $string = Helper::genStr2();
    $stop = xdebug_time_index() - $start;
    (float)$time1 += (float) $stop;
    //echo '<br>', '*** ', $stop, ' ***';
} echo $string;
echo '<br>Среднее время Helper::genStr2(): ', (float)$time1 / (float)10000;

if ((float)$time1 > (float)$time) {
    echo '<br>Скрипт Helper::genStr() быстрее на ', (float) $time1 / (float) $time * (float) 100, '%';
}
else {
    echo '<br>Скрипт Helper::genStr2() быстрее на ', (float) $time / (float) $time1 * (float) 100, '%';
}*/
/*$salt = /*'$2a$07$CLdaPl/5tI8Ka9U3U/M9jQ';*/ /*'$2a$07$' . $string;
$hash = crypt('lider', $salt);

$db_hash = substr($hash, 29);

echo '<br>', 'Соль: ', $salt,
     '<br>', 'Хэш: ', $hash,
     '<br>', 'Хэш в базе: ', $db_hash, '<br>',
     '<br>', strlen($hash), '<br>';
    (crypt('lider', $salt) === $salt . '.' . $db_hash) ? 'Успешная автризация!' : 'Пользователь не авторизован';*/
