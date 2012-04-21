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
    const ERR_INVALID_EMAIL    = 1; // ajax login
    const ERR_INVALID_PASSWORD = 2;
    const ERR_INVALID_ID       = 4; // cookie
    const ERR_INVALID_HASH     = 8;
    const ERR_USER_NOT_FOUND   = 16;// auth
    const ERR_WRONG_PASSWORD   = 32;

    const PREG_ID       = '/^\d{1,10}$/';
    const PREG_PS       = '/^[a-z0-9]{48}$/';
    const PREG_EMAIL    = '/^([a-zA-Z0-9]|_|\-|\.)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/';
    const PREG_PASSWORD = '/^[a-zA-Z0-9]{1,20}$/';

    // В переменной будет содержаться побитная информация об ошибках
    private $_errors = 0;

    private $_id;
    private $_hash;
    private $_email;
    private $_password;

    /**
     * @fn      __construct
     * @brief   Конструктор класса User
     * @details Авторизует пользователя по кукам. Если пользователь не авторизован,
     * создаётся экземпляр Guest.\n Если пользователь прислал GET-данные авторизации
     * через AJAX-форму, устанавливаем куки пользователю.
     */
    final public function __construct(&$user)
    {
        $auth = FALSE;

        switch (TRUE) {
            // Пользователь авторизуеся через ajax-форму
            case (isset($_GET['ln']) && isset($_GET['ps'])) :
                $this->_email    =& $_GET['ln'];
                $this->_password =& $_GET['ps'];

                $auth = $this->byAjax($user);
                break;
            // Пользователь уже авторизовался ранее
            case (isset($_COOKIE['id']) && isset($_COOKIE['ps'])) :
                $this->_id   =& $_COOKIE['id'];
                $this->_hash =& $_COOKIE['ps'];

                $auth = $this->byCookie($user);
                break;
        }

        if (!$auth) {
            $props = array('group' => $user::USR_GUEST);
            $user->setProperties($props);
        }
    }

    /**
     * @fn      setCookie
     * @brief   Установка авторизационных кук
     *
     * @return  void
     */
    final public static function setCookie($id, $hash)
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
     * @fn      delCookie
     * @brief   Удаление авторизационных кук
     *
     * @return  void
     */
    final public static function delCookie()
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
    private function secureVars($auth_type)
    {
        switch ($auth_type) {
            case 'cookie':
                if (!preg_match(self::PREG_ID, $this->_id))
                    $this->_errors |= self::ERR_INVALID_ID;

                if (!preg_match(self::PREG_PS, $this->_hash))
                    $this->_errors |= self::ERR_INVALID_HASH;
                break;
            case 'ajax':
                if (!preg_match(self::PREG_EMAIL, $this->_email))
                    $this->_errors |= self::ERR_INVALID_EMAIL;

                if (!preg_match(self::PREG_PASSWORD, $this->_password))
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
    final public function byCookie(&$user)
    {
        $this->secureVars('cookie');

        // Некорректные куки
        if ($this->_errors !== 0)
            return FALSE;

        // Пользователь с таким id не найден
        if (!$user->getByParam(array('id' => $this->_id))) {
            // Удаляем куки
            self::delCookie();
            $this->_errors |= self::ERR_USER_NOT_FOUND;
            return FALSE;
        }

        // Если хэш пароля не совпадает, удаляем куки
        if (!Password::checkHash($user)) {
            self::delCookie();
            $this->_errors |= self::ERR_WRONG_PASSWORD;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @fn      byAjax
     * @brief   Метод для авторизация пользователя AJAX-методом ($_GET)
     */
    final public function byAjax(&$user)
    {
        $this->secureVars('ajax');

        // Некорректные $_GET
        if ($this->_errors !== 0)
            return FALSE;

        // Пользователь уже авторизовался ранее, удаляем куки
        if (isset($_COOKIE['id']) || isset($_COOKIE['ps']))
            self::_delCookie();

        // Пользователь с таким логином найден
        if (!$user->getByParam(array('email' => $_GET['ln']))) {
            $this->_errors |= self::ERR_USER_NOT_FOUND;
            return FALSE;
        }

        // Если хэш пароля совпадает, устанавливаем авторизационные куки
        if (!Password::checkHash('ajax')) {
            $this->_errors |= self::ERR_WRONG_PASSWORD;
            return FALSE;
        }

        self::setCookie($user->getId(), $user->getHash());

        return TRUE;
    }

    /**
     * @fn      getErrors
     * @brief   Метод возвращает побитовые значения ошибок
     *
     * @return  int Побитовые значения ошибок авторизации
     */
    final public function getErrors()
    {
        return $this->_errors;
    }
}
