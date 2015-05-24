<?php
/**
 * Class for user password managing
 * @file    Password.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Сбт Апр 21 15:49:49 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Auth;

use Veles\Model\User;

/**
 * User password managing
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Password
{
	/**
	 * User hash check
	 *
	 * @param User $user
	 * @param $cookie_hash
	 * @return bool
	 */
	public static function checkCookieHash(User $user, &$cookie_hash)
	{
		return $user->getCookieHash() === $cookie_hash;
	}

	/**
	 * User password check in ajax-authentication
	 *
	 * @param User $user User
	 * @param string $password Password retrieved through ajax
	 * @return bool
	 */
	public static function check(User $user, &$password)
	{
		return $user->getHash() === crypt($password, $user->getHash());
	}
}
