<?php
/**
 * Фабрика. Содержит алогритм выбора стратегии авторизации
 *
 * @file      UserAuthFactory.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:34:29 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth;

use Veles\Auth\Strategies\AbstractAuthStrategy;
use Veles\Auth\Strategies\CookieStrategy;
use Veles\Auth\Strategies\GuestStrategy;
use Veles\Auth\Strategies\LoginFormStrategy;

/**
 * Класс UserAuthFactory
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @todo create method for custom auth-strategy setup. Provide system variables like POST, GET into strategy constructor during initialisation
 */
class UsrAuthFactory
{
	/**
	 * Алгритм выбора стратегии авторизации пользователя
	 * @return AbstractAuthStrategy
	 */
	public static function create()
	{
		switch (true) {
			case (isset($_POST['ln']) && isset($_POST['pw'])):
				return new LoginFormStrategy;
			case (isset($_COOKIE['id']) && isset($_COOKIE['pw'])):
				return new CookieStrategy($_COOKIE['id'], $_COOKIE['pw']);
			default:
				return new GuestStrategy;
		}
	}
}
