<?php
/**
 * Класс аторизации пользователя
 * @file    UsrAuth.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 16 21:45:26 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use \Veles\Model\User,
    \Veles\DataBase\DbFilter;

/**
 * Класс авторизации пользователя
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
final class UsrAuth
{
    const ERR_INVALID_EMAIL    = 1;  // ajax login
    const ERR_INVALID_PASSWORD = 2;
    const ERR_INVALID_ID       = 4;  // cookie
    const ERR_INVALID_HASH     = 8;
    const ERR_USER_NOT_FOUND   = 16; // auth
    const ERR_WRONG_PASSWORD   = 32;

    const PREG_COOKIE_ID   = '/^\d{1,10}$/';
    const PREG_COOKIE_HASH = '/^[a-zA-Z0-9\.\/]{31}$/';
    const PREG_PASSWORD    = '/^[a-zA-Z0-9]{1,20}$/';

    private $user;

    // В переменной будет содержаться побитная информация об ошибках
    private $errors = 0;

    private $cookie_id;
    private $cookie_hash;
    private $email;
    private $password;

    private static $instance;

    /**
     * Инициализация класса
     * @return UsrAuth
     */
    final public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = new UsrAuth();
        }

        return self::$instance;
    }

    /**
     * Конструктор класса UsrAuth
     *
     * Авторизует пользователя по кукам. Если пользователь не авторизован,
     * создаётся экземпляр User с группой Guest.\n Если пользователь прислал
     * данные авторизации через форму, устанавливаем куки пользователю.
     */
    final public function __construct()
    {
        $auth = false;

        $this->user = new User;

        // Пользователь авторизуется через запрос
        if (isset($_REQUEST['ln']) && isset($_REQUEST['pw'])) {
            $this->email    =& $_REQUEST['ln'];
            $this->password =& $_REQUEST['pw'];

            $auth = $this->byRequest();
        }
        // Пользователь уже авторизовался ранее
        elseif (isset($_COOKIE['id']) && isset($_COOKIE['pw'])) {
            $this->cookie_id   =& $_COOKIE['id'];
            $this->cookie_hash =& $_COOKIE['pw'];

            $auth = $this->byCookie();
        }

        if (!$auth) {
            $props = array('group' => UsrGroup::GUEST);
            $this->user->setProperties($props);
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
            'id', $id, $_SERVER['REQUEST_TIME'] + 31536000, '/', $_SERVER['HTTP_HOST'], false, false
        );
        // Пароль не шифруем, т.к. передан в функцию взятый из базы хэш пароля
        setcookie(
            'pw', $hash, $_SERVER['REQUEST_TIME'] + 31536000, '/', $_SERVER['HTTP_HOST'], false, false
        );
    }

    /**
     * Удаление авторизационных кук
     */
    final public static function delCookie()
    {
        setcookie('id', '', $_SERVER['REQUEST_TIME'] - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
        setcookie('pw', '', $_SERVER['REQUEST_TIME'] - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
    }

    /**
     * Установка авторизационных кук
     * @param string $auth_type
     */
    private function secureVars($auth_type)
    {
        if ('cookie' === $auth_type) {
            if (!preg_match(self::PREG_COOKIE_ID, $this->cookie_id))
                $this->errors |= UsrAuth::ERR_INVALID_ID;

            if (!preg_match(self::PREG_COOKIE_HASH, $this->cookie_hash))
                $this->errors |= UsrAuth::ERR_INVALID_HASH;
        }
        else {
            if (!Helper::validateEmail($this->email))
                $this->errors |= UsrAuth::ERR_INVALID_EMAIL;

            if (!preg_match(self::PREG_PASSWORD, $this->password))
                $this->errors |= UsrAuth::ERR_INVALID_PASSWORD;
        }
    }

    /**
     * Метод для авторизация пользователя с помощью кук
     * @return  bool
     */
    final private function byCookie()
    {
        $this->secureVars('cookie');

        // Некорректные куки
        if (0 !== $this->errors) {
            UsrAuth::delCookie();
            return false;
        }

        $filter = new DbFilter;
        // Ищем среди не удалённых пользователей
        $filter->setWhere("
            `id` = '$this->cookie_id'
            && `group` & " . UsrGroup::DELETED . ' = 0'
        );

        // Пользователь с таким id не найден
        if (!$this->user->find($filter)) {
            UsrAuth::delCookie();
            $this->errors |= UsrAuth::ERR_USER_NOT_FOUND;
            return false;
        }

        // Если хэш пароля не совпадает, удаляем куки
        if (!Password::checkCookieHash($this->user, $this->cookie_hash)) {
            UsrAuth::delCookie();
            $this->errors |= UsrAuth::ERR_WRONG_PASSWORD;
            return false;
        }

        return true;
    }

    /**
     * Метод для авторизации пользователя через запрос
     * @return bool
     */
    final private function byRequest()
    {
        $this->secureVars('ajax');

        // Некорректные $_GET
        if (0 !== $this->errors)
            return false;

        // Пользователь уже авторизовался ранее, удаляем куки
        if (isset($_COOKIE['id']) || isset($_COOKIE['pw']))
            UsrAuth::delCookie();

        $filter = new DbFilter;
        // Ищем среди не удалённых пользователей
        $filter->setWhere("
            `email` = '$this->email'
            && `group` & " . UsrGroup::DELETED . ' = 0'
        );

        // Пользователь с таким логином не найден
        if (!$this->user->find($filter)) {
            $this->errors |= UsrAuth::ERR_USER_NOT_FOUND;
            return false;
        }

        // Если хэш пароля совпадает, устанавливаем авторизационные куки
        if (!Password::check($this->user, $this->password)) {
            $this->errors |= UsrAuth::ERR_WRONG_PASSWORD;
            return false;
        }

        UsrAuth::setCookie($this->user->getId(), $this->user->getCookieHash());

        return true;
    }

    /**
     * Метод возвращает побитовые значения ошибок
     * @return int Побитовые значения ошибок авторизации
     */
    final public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Метод для проверки состоит ли пользователь в определённых группах
     * @param   array
     * @return  bool
     */
    final public function hasAccess($groups)
    {
        $user_group = $this->user->getGroup();

        // Проверяем есть ли в группах пользователя определённый бит,
        // соответствующий нужной группе.
        foreach ($groups as $group) {
            if ($group === ($user_group & $group))
                return true;
        }

        return false;
    }

    /**
     * Получение пользователя
     */
    final public function getUser()
    {
        return $this->user;
    }
}
