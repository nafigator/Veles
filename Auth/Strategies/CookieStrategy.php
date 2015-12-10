<?php
/**
 * User cookie auth strategy
 *
 * @file      CookieStrategy.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:44:08 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;

/**
 * Класс CookieStrategy
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class CookieStrategy extends AbstractAuthStrategy
{
	const PREG_COOKIE_ID   = '/^\d{1,10}$/';
	const PREG_COOKIE_HASH = '/^[a-z0-9\.\/]{31}$/i';

	protected $cookie_hash;
	protected $cookie_id;

	/**
	 * Конструктор
	 *
	 * @param string $id
	 * @param string $password
	 */
	public function __construct($id, $password)
	{
		parent::__construct();
		$this->cookie_id   = $id;
		$this->cookie_hash = $password;
	}

	/**
	 * Авторизация пользователя по кукам
	 *
	 * @return bool
	 */
	public function identify()
	{
		// Некорректные куки
		if (!$this->checkInput()) {
			$this->delCookie();
			return false;
		}

		$filter = new DbFilter;
		// Ищем среди не удалённых пользователей
		$where = "
			id = '$this->cookie_id'
			AND \"group\" & " . UsrGroup::DELETED . ' = 0 ';
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
	protected function checkInput()
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
