<?php
/**
 * Класс управления паролем пользователя
 * @file    Password.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Сбт Апр 21 15:49:49 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Auth;

use Veles\Model\User;

/**
 * Управление паролем пользователя
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Password
{
	/**
	 * Проверка хэша пользователя
	 * @param User $user
	 * @param $cookie_hash
	 * @return bool
	 */
	public static function checkCookieHash(User $user, &$cookie_hash)
	{
		return $user->getCookieHash() === $cookie_hash;
	}

	/**
	 * Проверка пароля пользователя при ajax-авторизации
	 * @param User $user User
	 * @param string $password Пароль полученый через ajax
	 * @return bool
	 */
	public static function check(User $user, &$password)
	{
		return $user->getHash() === crypt($password, $user->getHash());
	}
}
