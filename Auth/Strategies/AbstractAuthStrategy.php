<?php
/**
 * Базовый класс стратегий авторизации пользователя
 * @file    AbstractAuthStrategy.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Янв 27 17:29:50 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;
use Veles\Model\User;

/**
 * Класс AbstractAuthStrategy
 * @author   Alexander Yancharuk <alex@itvault.info>
 */
abstract class AbstractAuthStrategy
{
	const ERR_INVALID_EMAIL    = 1;  // form login
	const ERR_INVALID_PASSWORD = 2;
	const ERR_INVALID_ID       = 4;  // cookie
	const ERR_INVALID_HASH     = 8;
	const ERR_USER_NOT_FOUND   = 16; // auth
	const ERR_WRONG_PASSWORD   = 32;

	// В переменной будет содержаться побитная информация об ошибках
	protected $errors = 0;
	protected $user;

	/**
	 * Базовый конструктор
	 */
	public function __construct()
	{
		$this->user = new User;
	}

	/**
	 * Авторизация пользователя
	 * @return User
	 */
	abstract public function identify();

	/**
	 * Установка авторизационных кук
	 * @param int $identifier ID пользователя
	 * @param int $hash Хэш пароля
	 */
	final protected static function setCookie($identifier, $hash)
	{
		// Делаем куки на 1 год (3600*24*365)
		setcookie('id', $identifier, $_SERVER['REQUEST_TIME'] + 31536000, '/', $_SERVER['HTTP_HOST'], false, false);
		// Пароль не шифруем, т.к. передан в функцию взятый из базы хэш пароля
		setcookie('pw', $hash, $_SERVER['REQUEST_TIME'] + 31536000, '/', $_SERVER['HTTP_HOST'], false, false);
	}

	/**
	 * Удаление авторизационных кук
	 */
	final protected static function delCookie()
	{
		setcookie('id', '', $_SERVER['REQUEST_TIME'] - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
		setcookie('pw', '', $_SERVER['REQUEST_TIME'] - 3600, '/', $_SERVER['HTTP_HOST'], false, false);
	}

	/**
	 * Поиск пользователя
	 * @param DbFilter $filter
	 * @return bool
	 */
	final protected function findUser(DbFilter $filter)
	{
		// Пользователь с таким id найден
		if ($this->user->find($filter)) {
			return true;
		}

		$this->delCookie();

		$props = array('group' => UsrGroup::GUEST);
		$this->user->setProperties($props);

		$this->errors |= self::ERR_USER_NOT_FOUND;
		return false;
	}

	/**
	 * Получение пользователя
	 * @return User
	 */
	final public function getUser()
	{
		return $this->user;
	}

	/**
	 * Получение ошибок
	 * @return int
	 */
	final public function getErrors()
	{
		return $this->errors;
	}
}
