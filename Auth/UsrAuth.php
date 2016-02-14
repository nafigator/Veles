<?php
/**
 * User authentication class
 *
 * @file      UsrAuth.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Птн Мар 16 21:45:26 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Auth;

use Veles\Model\User;
use Veles\Traits\SingletonInstance;

/**
 * User authentication class
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class UsrAuth
{
	protected $identified = false;
	protected $strategy;

	use SingletonInstance;

	/**
	 * User authentication strategy initialization
	 */
	protected function __construct()
	{
		$this->strategy   = (new UsrAuthFactory)->create();
		$this->identified = $this->strategy->identify();
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
	 * @param int $groups Sum of user groups
	 *
	 * @return bool
	 */
	public static function hasAccess($groups)
	{
		$user_group = self::getUser()->getGroup();

		return $groups === ($user_group & $groups);
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
