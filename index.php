<?php

//require_once 'includes/db_connect.inc';
//require_once 'includes/UserTables.class.inc';

define('DEBUG', TRUE);

function __autoload($name) {
    try {
        require_once "lib/$name.php";
    }
    catch (Exception $e){
        print $e->getMessage();
    }
}

$user_tables = new UserTables();

$user_tables->create();

$user_tables->drop();



$user = new User;
$user->auth();
var_dump($user);
$groups = array(8, 3, 2);
var_dump($user->hasAccess($groups));

var_dump(Db::getDebugData());
