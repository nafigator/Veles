<?php
/**
 * Usr authentication strategy base class
 *
 * @file      AbstractAuthStrategy.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:29:50 2013
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;
use Veles\Model\User;

/**
 * Class AbstractAuthStrategy
 * @author   Alexander Yancharuk <alex at itvault dot info>
 */
abstract class AbstractAuthStrategy
{
	const ERR_INVALID_EMAIL    = 1;  // form login
	const ERR_INVALID_PASSWORD = 2;
	const ERR_INVALID_ID       = 4;  // cookie
	const ERR_INVALID_HASH     = 8;
	const ERR_USER_NOT_FOUND   = 16; // auth
	const ERR_WRONG_PASSWORD   = 32;

	// This var contains bit-wise error info
	protected $errors = 0;
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->user = new User;
	}

	/**
	 * User authentication
	 *
	 * @return User
	 */
	abstract public function identify();

	/**
	 * Auth cookies setup
	 *
	 * @param int $identifier ID пользователя
	 * @param int $hash Хэш пароля
	 * @codeCoverageIgnore
	 */
	protected static function setCookie($identifier, $hash)
	{
		// Делаем куки на 1 год (3600*24*365)
		setcookie('id', $identifier, $_SERVER['REQUEST_TIME'] + 31536000, '/', $_SERVER['HTTP_HOST'], false, false);
		// Пароль не шифруем, т.к. передан в функцию взятый из базы хэш пароля
		setcookie('pw', $hash, $_SERVER['REQUEST_TIME'] + 31536000, '/', $_SERVER['HTTP_HOST'], false, false);
	}

	/**
	 * Delete auth cookies
	 * @codeCoverageIgnore
	 */
	protected static function delCookie()
	{
		setcookie('id', '', $_SERVER['REQUEST_TIME'] - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
		setcookie('pw', '', $_SERVER['REQUEST_TIME'] - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
	}

	/**
	 * User search
	 *
	 * @param DbFilter $filter
	 * @return bool
	 */
	protected function findUser(DbFilter $filter)
	{
		if ($this->user->find($filter)) {
			return true;
		}

		$this->delCookie();

		$props = ['group' => UsrGroup::GUEST];
		$this->user->setProperties($props);

		$this->errors |= self::ERR_USER_NOT_FOUND;
		return false;
	}

	/**
	 * Get user
	 *
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Get errors
	 *
	 * @return int
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}
