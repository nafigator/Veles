<?php
/**
 * Фабрика. Содержит алогритм выбора стратегии авторизации
 * @file    UserAuthFactory.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 27 17:34:29 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Auth;

use \Veles\Auth\Strategies\LoginFormStrategy;
use \Veles\Auth\Strategies\CookieStrategy;
use \Veles\Auth\Strategies\GuestStrategy;
use \Veles\Auth\Strategies\AbstractAuthStrategy;

/**
 * Класс UserAuthFactory
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UsrAuthFactory
{
    /**
     * Алгритм выбора стратегии авторизации пользователя
     * @return AbstractAuthStrategy
     */
    final public static function create()
    {
        switch (true) {
            case (isset($_REQUEST['ln']) && isset($_REQUEST['pw'])):
                return new LoginFormStrategy;
            case (isset($_COOKIE['id']) && isset($_COOKIE['pw'])):
                return new CookieStrategy;
            default:
                return new GuestStrategy;
        }
    }
}
