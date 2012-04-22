<?php
/**
 * @file    Auth.php
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
                $this->email    =& $_GET['ln'];
                $this->password =& $_GET['ps'];

                $auth = $this->byAjax($user);
                break;
            // Пользователь уже авторизовался ранее
            case (isset($_COOKIE['id']) && isset($_COOKIE['ps'])) :
                $this->cookie_id   =& $_COOKIE['id'];
                $this->cookie_hash =& $_COOKIE['ps'];

                $auth = $this->byCookie($user);
                break;
        }

        if (!$auth) {
            $props = array('group' => User::GUEST);
            $user->setProperties($props);
        }
    }

    /**
     * @fn     checkEmail
     * @brief  Валидация email
     *
     * @param  string $email
     * @return bool
     */
    final public function checkEmail($email, $check_domain = FALSE)
    {
        if (preg_match(self::PREG_EMAIL, $email)) {
            if ($check_domain) {
                list($username, $domain) = explode('@', $email);

                if (!(checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'))) {
                    $this->errors |= self::ERR_WRONG_DOMAIN;
                    return FALSE;
                }
            }

            return TRUE;
        }
        else {
            $this->errors |= self::ERR_INVALID_EMAIL;
            return FALSE;
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
        if ($auth_type === 'cookie') {
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
     * @fn      byCookie
     * @brief   Метод для авторизация пользователя с помощью кук
     *
     * @return  bool
     */
    final public function byCookie(&$user)
    {
        $this->secureVars('cookie');

        // Некорректные куки
        if ($this->errors !== 0)
            return FALSE;

        // Пользователь с таким id не найден
        if (!$user->getActive(array('id' => $this->cookie_id))) {
            // Удаляем куки
            self::delCookie();
            $this->errors |= self::ERR_USER_NOT_FOUND;
            return FALSE;
        }

        // Если хэш пароля не совпадает, удаляем куки
        if (!Password::checkCookieHash($user, $this->cookie_hash)) {
            self::delCookie();
            $this->errors |= self::ERR_WRONG_PASSWORD;
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
        if ($this->errors !== 0)
            return FALSE;

        // Пользователь уже авторизовался ранее, удаляем куки
        if (isset($_COOKIE['id']) || isset($_COOKIE['ps']))
            self::delCookie();

        // Пользователь с таким логином найден
        if (!$user->getActive(array('email' => $this->email))) {
            $this->errors |= self::ERR_USER_NOT_FOUND;
            return FALSE;
        }

        // Если хэш пароля совпадает, устанавливаем авторизационные куки
        if (!Password::check($user, $this->password)) {
            $this->errors |= self::ERR_WRONG_PASSWORD;
            return FALSE;
        }

        self::setCookie($user->getId(), $user->getCookieHash());

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
        return $this->errors;
    }
}
