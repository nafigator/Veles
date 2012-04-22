<?php
/**
 * @file    Password.php
 * @brief   Класс управления паролем пользователя
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Апр 21 15:49:49 2012
 * @version
 */

/**
 * @class Password
 * @brief Управление паролем пользователя
 */
class Password {
    /**
     * @fn    checkHash
     * @brief Проверка хэша пользователя
     *
     * @param $user
     */
    final public static function checkCookieHash(&$user, &$cookie_hash)
    {
        return $user->getCookieHash() === $cookie_hash;
    }

    /**
     * @fn    check
     * @brief Проверка пароля пользователя при ajax-авторизации
     *
     * @param object $user     User
     * @param string $password Пароль полученый ajax'ом
     */
    final public static function check(&$user, &$password)
    {
        return $user->getHash() === crypt($password, $user->getSalt());
    }
}
