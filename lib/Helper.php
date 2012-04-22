<?php
/**
 * @file    Helper.php
 * @brief   Набор полезных функций
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Апр 21 20:59:37 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class Helper
 * @brief Набор полезных функций
 */
class Helper {
    /**
     * @fn    genStr
     * @brief Генерирует случайный набор символов заданной длины
     *
     * По-умолчанию настройки для генерации blowfish соли
     *
     * @param int $length
     */
    final public static function genStr($length = 21,
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./')
    {
        return substr(str_shuffle(str_repeat($letters, 5)), 0, $length);
    }

    /**
     * @fn    validateEmail
     * @brief Метод для проверки email
     *
     * @param string $email
     */
    final public static function validateEmail($email)
    {
        return preg_match('/^([a-zA-Z0-9]|_|\-|\.)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/', $email);
    }

    /**
     * @fn    checkEmailDomain
     * @brief Метод для проверки mail-домена
     *
     * @param string $email
     */
    final public static function checkEmailDomain($email)
    {
        list($u, $domain) = explode('@', $email);

        return checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
    }
}
