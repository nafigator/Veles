<?php
/**
 * Фабрика. Содержит алогритм выбора стратегии авторизации
 *
 * @file      UserAuthFactory.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Вск Янв 27 17:34:29 2013
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>.
 */

namespace Veles\Auth;

use Veles\Auth\Strategies\AbstractAuthStrategy;
use Veles\Auth\Strategies\CookieStrategy;
use Veles\Auth\Strategies\GuestStrategy;
use Veles\Auth\Strategies\LoginFormStrategy;

/**
 * Класс UserAuthFactory
 * @author  Alexander Yancharuk <alex at itvault dot info>
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
				return new CookieStrategy;
			default:
				return new GuestStrategy;
		}
	}
}
