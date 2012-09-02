<?php
/**
 * Набор полезных функций
 * @file    Helper.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Апр 21 20:59:37 2012
 * @copyright The BSD 2-Clause License. http://opensource.org/licenses/bsd-license.php
 */

namespace Veles;

/**
 * Набор полезных функций
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Helper {
    /**
     * Генерирует случайный набор символов заданной длины.
     * По-умолчанию настройки для генерации blowfish соли
     * @param int $length Длина генерируемой строки
     * @param string $letters Набор символов
     */
    final public static function genStr(
        $length  = 21,
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./'
    )
    {
        return substr(str_shuffle(str_repeat($letters, 5)), 0, $length);
    }

    /**
     * Метод для проверки email
     * @param string $email
     */
    final public static function validateEmail($email)
    {
        return preg_match('/^(?:[a-zA-Z0-9]|_|\-|\.)+@(?:(?:[a-z0-9_]|\-)+\.)+[a-z]{2,6}$/', $email);
    }

    /**
     * Метод для проверки mail-домена
     * @param string $email
     */
    final public static function checkEmailDomain($email)
    {
        list(, $domain) = explode('@', $email);

        return checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
    }
}
