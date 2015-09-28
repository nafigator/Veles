<?php
/**
 * User authentication class
 *
 * @file      UsrAuth.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Птн Мар 16 21:45:26 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Auth;

use Veles\Model\User;

/**
 * User authentication class
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class UsrAuth
{
	protected $identify = false;
	protected $strategy;
	protected static $instance;

	/**
	 * User authentication
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
	 * User authentication strategy initialization
	 */
	protected function __construct()
	{
		$this->strategy = UsrAuthFactory::create();
		$this->identify = $this->strategy->identify();
	}

	/**
	 * Method returns bitwise values of auth-errors
	 *
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
