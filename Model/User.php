<?php
/**
 * User model
 *
 * @file      User.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      Пнд Мар 05 21:39:43 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Model;

use Veles\Auth\UsrGroup;

/**
 * Модель пользователя
 */
class User extends ActiveRecord
{
	const TBL_NAME      = 'users';
	const TBL_USER_INFO = 'users_info';

	protected $map = [
		'id'         => 'int',
		'email'      => 'string',
		'hash'       => 'string',
		'group'      => 'int',
		'last_login' => 'string'
	];
	public $email;
	public $hash;
	public $group;

	/**
	 * Метод для получения ID пользователя
	 * @return int|null
	 */
	public function getId()
	{
		return isset($this->id) ? (int) $this->id : null;
	}

	/**
	 * Метод для получения хэша пользователя, взятого из базы
	 * @return string|null
	 */
	public function getHash()
	{
		return isset($this->hash) ? $this->hash : null;
	}

	/**
	 * Метод для получения хэша для кук
	 * @return string|null
	 */
	public function getCookieHash()
	{
		return isset($this->hash) ? substr($this->hash, 29) : null;
	}

	/**
	 * Метод для получения соли хэша
	 * @return string|null
	 */
	public function getSalt()
	{
		return isset($this->hash) ? substr($this->hash, 0, 28) : null;
	}

	/**
	 * Метод для получения группы пользователя
	 * @return int
	 */
	public function getGroup()
	{
		return isset($this->group) ? (int) $this->group : UsrGroup::GUEST;
	}
}
