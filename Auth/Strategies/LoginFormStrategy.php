<?php
/**
 * User form authentication strategy
 *
 * @file      LoginFormStrategy.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:40:18 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\Password;
use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;
use Veles\Model\User;

/**
 * Class LoginFormStrategy
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class LoginFormStrategy extends AbstractAuthStrategy
{
	protected $login;
	protected $password;

	/**
	 * @param string $login User login
	 * @param string $password
	 * @param User   $user
	 */
	public function __construct($login, $password, User $user)
	{
		parent::__construct($user);
		$this->setLogin($login)->setPassword($password);
	}

	/**
	 * User authentication by login form
	 *
	 * @return bool
	 */
	public function identify()
	{
		$filter = new DbFilter;

		$where = 'email = \'' . $this->getLogin() . '\'
			AND "group" & ' . UsrGroup::DELETED . ' = 0 ';
		$filter->setWhere($where);

		if (!$this->findUser($filter))
			return false;

		$this->delCookie();

		if (!Password::check($this->getUser(), $this->getPassword())) {
			$this->errors |= self::ERR_WRONG_PASSWORD;
			return false;
		}

		$this->setCookie(['expired' => strtotime('+365 days')]);

		return true;
	}

	/**
	 * @return string
	 */
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * @param string $login
	 *
	 * @return LoginFormStrategy
	 */
	public function setLogin($login)
	{
		$this->login = $login;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 *
	 * @return LoginFormStrategy
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}
}
