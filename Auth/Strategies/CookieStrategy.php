<?php
/**
 * Стратегия авторизации пользователя по кукам
 * @file    CookieStrategy.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 27 17:44:08 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;

/**
 * Класс CookieStrategy
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class CookieStrategy extends AbstractAuthStrategy
{
	const PREG_COOKIE_ID   = '/^\d{1,10}$/';
	const PREG_COOKIE_HASH = '/^[a-zA-Z0-9\.\/]{31}$/';

	private $cookie_hash;
	private $cookie_id;

	/**
	 * Конструктор
	 */
	final public function __construct()
	{
		parent::__construct();
		$this->cookie_id   =& $_COOKIE['id'];
		$this->cookie_hash =& $_COOKIE['pw'];
	}

	/**
	 * Авторизация пользователя по кукам
	 * @return bool
	 */
	final public function identify()
	{
		// Некорректные куки
		if (!$this->checkInput()) {
			$this->delCookie();
			return false;
		}

		$filter = new DbFilter;
		// Ищем среди не удалённых пользователей
		$where = "
			`id` = '$this->cookie_id'
			&& `group` & " . UsrGroup::DELETED . ' = 0 ';
		$filter->setWhere($where);

		if (!$this->findUser($filter)) {
			return false;
		}

		// Если хэш пароля не совпадает, удаляем куки
		if ($this->user->getCookieHash() !== $this->cookie_hash) {
			$this->delCookie();
			$this->errors |= self::ERR_WRONG_PASSWORD;
			return false;
		}

		return true;
	}

	/**
	 * Проверка входящих значений
	 */
	private function checkInput()
	{
		if (!preg_match(self::PREG_COOKIE_ID, $this->cookie_id)) {
			$this->errors |= self::ERR_INVALID_ID;
		}

		if (!preg_match(self::PREG_COOKIE_HASH, $this->cookie_hash)) {
			$this->errors |= self::ERR_INVALID_HASH;
		}

		return 0 === $this->errors;
	}
}
