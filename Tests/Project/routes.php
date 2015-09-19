<?php
/**
 * This is example of routes config written on pure php
 *
 * @file    routes.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 18:11
 * @license The BSD 3-Clause License <http://opensource.org/licenses/BSD-3-Clause>
 */

return [
	'Home'     => [
		'class'      => 'Veles\Routing\RouteRegex',
		'view'       => 'Veles\View\Adapters\NativeAdapter',
		'route'      => '#^\/(?:index.html|page\-(\d+)\.html)?$#',
		'tpl'        => 'Frontend/index.phtml',
		'controller' => 'Frontend\Home',
		'action'     => 'index',
		'map'        => [
			1 => 'page'
		]
	],
	'TestMap'  => [
		'class'      => 'Veles\Routing\RouteRegex',
		'view'       => 'Veles\View\Adapters\NativeAdapter',
		'route'      => '#^\/book\/(\d+)\/user\/(\d+)$#',
		'tpl'        => 'Frontend/index.phtml',
		'controller' => 'Frontend\Home',
		'action'     => 'book',
		'map'        => [
			1 => 'book_id',
			2 => 'user_id',
		]
	],
	'Contacts' => [
		'class'      => 'Veles\Routing\RouteStatic',
		'route'      => '/contacts',
		'controller' => 'Frontend\Contacts',
		'action'     => 'getAddress',
		'ajax'       => '1',
	],
	'User'     => [
		'class' => 'Veles\Routing\RouteStatic',
		'route' => '/user',
	]
];
