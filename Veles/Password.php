<?php
/**
 * Класс управления паролем пользователя
 * @file    Password.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Апр 21 15:49:49 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use \Veles\Model\User;

/**
 * Управление паролем пользователя
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Password
{
    /**
     * Проверка хэша пользователя
     * @param $user
     * @return bool
     */
    final public static function checkCookieHash(User $user, &$cookie_hash)
    {
        return $user->getCookieHash() === $cookie_hash;
    }

    /**
     * Проверка пароля пользователя при ajax-авторизации
     * @param object $user     User
     * @param string $password Пароль полученый ajax'ом
     * @return bool
     */
    final public static function check(User $user, &$password)
    {
        return $user->getHash() === crypt($password, $user->getSalt());
    }
}
