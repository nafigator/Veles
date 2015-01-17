<?php
/**
 * Группы пользователей
 * @file    UsrGroup.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Вск Ноя 04 08:18:08 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Auth;

/**
 * Класс UsrGroup
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class UsrGroup
{
	// Группы пользователя
	const ADMIN      = 1;
	const MANAGER    = 2;
	const MODERATOR  = 4;
	const REGISTERED = 8;
	const GUEST      = 16;
	const DELETED    = 32;
}
