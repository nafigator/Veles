<?php
/**
 * User authentification class
 * @file    UsrAuth.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Мар 16 21:45:26 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Auth;

use Veles\Model\User;

/**
 * User authentification class
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class UsrAuth
{
	protected $identify = false;
	protected $strategy;
	protected static $instance;

	/**
	 * User authentification
	 *
	 * @return UsrAuth
	 */
	public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();

			static::$instance = new $class;
		}

		return static::$instance;
	}

	/**
	 * User authentification strategy initialization
	 */
	protected function __construct()
	{
		$this->strategy = UsrAuthFactory::create();
		$this->identify = $this->strategy->identify();
	}

	/**
	 * Method returns bitwise values of auth-errors
	 * @return int Bitwise auth-errors
	 */
	public static function getErrors()
	{
		return self::instance()->strategy->getErrors();
	}

	/**
	 * Check for user groups
	 *
	 * @param   array
	 * @return  bool
	 * @todo переделать входящий параметр на int
	 */
	public static function hasAccess(array $groups)
	{
		$user_group = self::getUser()->getGroup();

		// Проверяем есть ли в группах пользователя определённый бит,
		// соответствующий нужной группе.
		foreach ($groups as $group) {
			if ($group === ($user_group & $group)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get user
	 *
	 * @return User
	 */
	public static function getUser()
	{
		return self::instance()->strategy->getUser();
	}
}
