<?php
/**
 * User form authentication strategy
 *
 * @file      LoginFormStrategy.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:40:18 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\Password;
use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;
use Veles\Helper;

/**
 * Class LoginFormStrategy
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class LoginFormStrategy extends AbstractAuthStrategy
{
	const PREG_PASSWORD    = '/^[a-z0-9_-]{1,20}$/i';

	/**
	 * @param $login
	 * @param $password
	 */
	public function __construct($login, $password)
	{
		parent::__construct();
		$this->email    = $login;
		$this->password = $password;
	}

	/**
	 * User authentication by login form
	 *
	 * @return bool
	 */
	public function identify()
	{
		// Некорректные $_GET
		if (!$this->checkInput()) {
			return false;
		}

		$filter = new DbFilter;
		// Ищем среди не удалённых пользователей
		$where = "
			email = '$this->email'
			AND \"group\" & " . UsrGroup::DELETED . ' = 0 ';
		$filter->setWhere($where);

		if (!$this->findUser($filter)) {
			return false;
		}

		$this->delCookie();

		// Если хэш пароля совпадает, устанавливаем авторизационные куки
		if (!Password::check($this->user, $this->password)) {
			$this->errors |= self::ERR_WRONG_PASSWORD;
			return false;
		}

		$this->setCookie($this->user->getId(), $this->user->getCookieHash());

		return true;
	}

	/**
	 * Проверка входящих значений
	 */
	private function checkInput()
	{
		if (!Helper::validateEmail($this->email)) {
			$this->errors |= self::ERR_INVALID_EMAIL;
		}

		if (!preg_match(self::PREG_PASSWORD, $this->password)) {
			$this->errors |= self::ERR_INVALID_PASSWORD;
		}

		return 0 === $this->errors;
	}
}
