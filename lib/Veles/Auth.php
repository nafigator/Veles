<?php
/**
 * Класс аторизации пользователя
 * @file    Auth.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 16 21:45:26 2012
 * @version
 */

namespace Veles;

/**
 * Класс авторизации пользователя
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
final class Auth
{
    const ERR_INVALID_EMAIL    = 1;  // ajax login
    const ERR_INVALID_PASSWORD = 2;
    const ERR_INVALID_ID       = 4;  // cookie
    const ERR_INVALID_HASH     = 8;
    const ERR_USER_NOT_FOUND   = 16; // auth
    const ERR_WRONG_PASSWORD   = 32;
    const ERR_WRONG_DOMAIN     = 64;

    const PREG_COOKIE_ID   = '/^\d{1,10}$/';
    const PREG_COOKIE_HASH = '/^[a-zA-Z0-9\.\/]{31}$/';
    const PREG_PASSWORD    = '/^[a-zA-Z0-9]{1,20}$/';

    // В переменной будет содержаться побитная информация об ошибках
    private $errors = 0;

    private $cookie_id;
    private $cookie_hash;
    private $email;
    private $password;

    /**
     * Конструктор класса User.
     * Авторизует пользователя по кукам. Если пользователь не авторизован,
     * создаётся экземпляр Guest.\n Если пользователь прислал данные авторизации
     * через форму, устанавливаем куки пользователю.
     * @param CurrentUser $user
     */
    final public function __construct(CurrentUser $user)
    {
        $auth = false;

        switch (true) {
            // Пользователь уже авторизовался ранее
            case (isset($_COOKIE['id']) && isset($_COOKIE['pw'])) :
                $this->cookie_id   =& $_COOKIE['id'];
                $this->cookie_hash =& $_COOKIE['pw'];

                $auth = $this->byCookie($user);
                break;
            // Пользователь авторизуеся через запрос
            case (isset($_REQUEST['ln']) && isset($_REQUEST['pw'])) :
                $this->email    =& $_REQUEST['ln'];
                $this->password =& $_REQUEST['pw'];

                $auth = $this->byRequest($user);
                break;
        }

        if (!$auth) {
            $props = array('group' => CurrentUser::GUEST);
            $user->setProperties($props);
        }
    }

    /**
     * Установка авторизационных кук
     * @param int $id
     * @param int $hash
     */
    final public static function setCookie($id, $hash)
    {
        // Делаем куки на 1 год (3600*24*365)
        setcookie(
            'id', $id, time() + 31536000, '/', $_SERVER['HTTP_HOST'], false, false
        );
        // Пароль не шифруем, т.к. передан в функцию взятый из базы хэш пароля
        setcookie(
            'pw', $hash, time() + 31536000, '/', $_SERVER['HTTP_HOST'], false, false
        );
    }

    /**
     * Удаление авторизационных кук
     */
    final public static function delCookie()
    {
        setcookie('id', '', time() - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
        setcookie('pw', '', time() - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
    }

    /**
     * Установка авторизационных кук
     * @param string $auth_type
     */
    private function secureVars($auth_type)
    {
        if ('cookie' === $auth_type) {
            if (!preg_match(self::PREG_COOKIE_ID, $this->cookie_id))
                $this->errors |= self::ERR_INVALID_ID;

            if (!preg_match(self::PREG_COOKIE_HASH, $this->cookie_hash))
                $this->errors |= self::ERR_INVALID_HASH;
        }
        else {
            if (!Helper::validateEmail($this->email))
                $this->errors |= self::ERR_INVALID_EMAIL;

            if (!preg_match(self::PREG_PASSWORD, $this->password))
                $this->errors |= self::ERR_INVALID_PASSWORD;
        }
    }

    /**
     * Метод для авторизация пользователя с помощью кук
     * @return  bool
     */
    final private function byCookie(CurrentUser $user)
    {
        $this->secureVars('cookie');

        // Некорректные куки
        if (0 !== $this->errors)
            return false;

        // Пользователь с таким id не найден
        if (!$user->findActive(array('id' => $this->cookie_id))) {
            // Удаляем куки
            self::delCookie();
            $this->errors |= self::ERR_USER_NOT_FOUND;
            return false;
        }

        // Если хэш пароля не совпадает, удаляем куки
        if (!Password::checkCookieHash($user, $this->cookie_hash)) {
            self::delCookie();
            $this->errors |= self::ERR_WRONG_PASSWORD;
            return false;
        }

        return true;
    }

    /**
     * Метод для авторизации пользователя через запрос
     */
    final private function byRequest(CurrentUser $user)
    {
        $this->secureVars('ajax');

        // Некорректные $_GET
        if (0 !== $this->errors)
            return false;

        // Пользователь уже авторизовался ранее, удаляем куки
        if (isset($_COOKIE['id']) || isset($_COOKIE['pw']))
            self::delCookie();

        // Пользователь с таким логином найден
        if (!$user->findActive(array('email' => $this->email))) {
            $this->errors |= self::ERR_USER_NOT_FOUND;
            return false;
        }

        // Если хэш пароля совпадает, устанавливаем авторизационные куки
        if (!Password::check($user, $this->password)) {
            $this->errors |= self::ERR_WRONG_PASSWORD;
            return false;
        }

        self::setCookie($user->getId(), $user->getCookieHash());

        return true;
    }

    /**
     * Метод возвращает побитовые значения ошибок
     * @return  int Побитовые значения ошибок авторизации
     */
    final public function getErrors()
    {
        return $this->errors;
    }
}
