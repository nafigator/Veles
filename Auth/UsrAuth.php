<?php
/**
 * Класс аторизации пользователя
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
 * Класс авторизации пользователя
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class UsrAuth
{
	protected $identify = false;
	protected $strategy;
	protected static $instance;

	/**
	 * Проверка авторизации пользователя
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
	 * Инициализация стратегии и пользователя
	 */
	protected function __construct()
	{
		$this->strategy = UsrAuthFactory::create();
		$this->identify = $this->strategy->identify();
	}

	/**
	 * Метод возвращает побитовые значения ошибок
	 * @return int Побитовые значения ошибок авторизации
	 */
	public static function getErrors()
	{
		return self::instance()->strategy->getErrors();
	}

	/**
	 * Метод для проверки состоит ли пользователь в определённых группах
	 * @param   array
	 * @return  bool
	 * @todo переделать входящий параметр на int
	 */
	public static function hasAccess($groups)
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
	 * Получение пользователя
	 * @return User
	 */
	public static function getUser()
	{
		return self::instance()->strategy->getUser();
	}
}
