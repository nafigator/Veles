<?php
/**
 * @file    Auth.class.inc
 * @brief   Класс аторизации пользователя
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 16 21:45:26 2012
 * @version
 */

final class Auth
{
    const ERR_INVALID_EMAIL    = 1; // login
    const ERR_INVALID_PASSWORD = 2;
    const ERR_INVALID_ID       = 4;
    const ERR_INVALID_HASH     = 8;
    const ERR_USER_NOT_FOUND   = 16;
    const ERR_WRONG_PASSWORD   = 32;

    const PREG_ID       = '/^\d{1,10}$/';
    const PREG_PS       = '/^[a-z0-9]{48}$/';
    const PREG_EMAIL    = '';
    const PREG_PASSWORD = '[a-zA-Z0-9]{20}';

    // В переменной будет содержаться побитная информация об ошибках
    private $_errors = 0;

    /**
     * @fn      _setCookie
     * @brief   Установка авторизационных кук
     *
     * @return  void
     */
    private static function _setCookie($id, $hash)
    {
        // Делаем куки на 1 год (3600*24*365)
        setcookie(
            'id', $id, time() + 31536000, '/', $_SERVER['HTTP_HOST'], FALSE, FALSE
        );
        // Пароль не шифруем, т.к. передан в функцию взятый из базы хэш пароля
        setcookie(
            'ps', $hash, time() + 31536000, '/', $_SERVER['HTTP_HOST'], FALSE, FALSE
        );
    }

    /**
     * @fn      _delCookie
     * @brief   Удаление авторизационных кук
     *
     * @return  void
     */
    private static function _delCookie()
    {
        setcookie('id', '', time() - 3600, '/', $_SERVER['HTTP_HOST'], FALSE, FALSE);
        setcookie('ps', '', time() - 3600, '/', $_SERVER['HTTP_HOST'], FALSE, FALSE);
    }

    /**
     * @fn      secureVars
     * @brief   Установка авторизационных кук
     *
     * @return  void
     */
    private static function secureVars($auth_type)
    {
        switch ($auth_type) {
            case 'cookie':
                if (!preg_match(PREG_ID, $_COOKIE['id']))
                    $this->_errors |= self::ERR_INVALID_ID;

                if (!preg_match(PREG_PS, $_COOKIE['ps']))
                    $this->_errors |= self::ERR_INVALID_HASH;
                break;
            case 'ajax':
                if (!preg_match(PREG_EMAIL, $_GET['email']))
                    $this->_errors |= self::ERR_INVALID_EMAIL;

                if (!preg_match(PREG_PASSWORD, $_GET['password']))
                    $this->_errors |= self::ERR_INVALID_PASSWORD;
                break;
        }
    }

    /**
     * @fn      byCookie
     * @brief   Метод для авторизация пользователя с помощью кук
     *
     * @return  bool
     */
    public static function byCookie()
    {
        self::secureVars('cookie');

        // Некорректные куки
        if ($this->_errors !== 0)
            return FALSE;

        // Пользователь с таким id не найден
        if (!User::getById($_COOKIE['id'])) {
            // Удаляем куки
            self::_delCookie();
            $this->_errors |= self::ERR_USER_NOT_FOUND;
            return FALSE;
        }

        // Если хэш пароля не совпадает, удаляем куки
        if (!Password::check('cookie')) {
            $this->_delCookie();
            $this->_errors |= self::ERR_WRONG_PASSWORD;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @fn      byAjax
     * @brief   Метод для авторизация пользователя AJAX-методом ($_GET)
     */
    public static function byAjax()
    {
        self::secureVars('ajax');

        // Некорректные $_GET
        if ($this->_errors !== 0)
            return FALSE;

        // Пользователь уже авторизовался ранее, удаляем куки
        if (isset($_COOKIE['id']) || isset($_COOKIE['ps']))
            self::_delCookie();

        // Пользователь с таким логином найден
        if (!User::getByEmail($_GET['ln'])) {
            $this->_errors |= self::ERR_USER_NOT_FOUND;
            return FALSE;
        }

        // Если хэш пароля совпадает, устанавливаем авторизационные куки
        if (!Password::check('ajax')) {
            $this->_errors |= self::ERR_WRONG_PASSWORD;
            return FALSE;
        }

        self::_setCookie(User::getId(), User::getHash());

        return TRUE;
    }

    /**
     * @fn      getErrors
     * @brief   Метод возвращает побитовые значения ошибок
     *
     * @return  int Побитовые значения ошибок авторизации
     */
    public static function getErrors()
    {
        return $this->_errors;
    }
}
