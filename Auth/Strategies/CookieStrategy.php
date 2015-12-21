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
use Veles\Model\User;

/**
 * Class CookieStrategy
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class CookieStrategy extends AbstractAuthStrategy
{
	protected $password_hash;
	protected $identifier;

	/**
	 * Constructor
	 *
	 * @param string $id
	 * @param string $password_hash
	 * @param User   $user
	 */
	public function __construct($id, $password_hash, User $user)
	{
		parent::__construct($user);

		$this->setId($id)->setPasswordHash($password_hash);
	}

	/**
	 * User authentication by cookies
	 *
	 * @return bool
	 */
	public function identify()
	{
		$filter = new DbFilter;
		// Search within not deleted users
		$where = 'id = ' . $this->getId() . '
			AND "group" & ' . UsrGroup::DELETED . ' = 0 ';
		$filter->setWhere($where);

		if (!$this->findUser($filter))
			return false;

		// If hash doesn't match, delete cookies
		if ($this->getUser()->getCookieHash() !== $this->getPasswordHash()) {
			$this->delCookie();
			$this->errors |= self::ERR_WRONG_PASSWORD;
			return false;
		}

		return true;
	}

	/**
	 * @return string
	 */
	public function getPasswordHash()
	{
		return $this->password_hash;
	}

	/**
	 * @param string $password_hash
	 *
	 * @return $this
	 */
	public function setPasswordHash($password_hash)
	{
		$this->password_hash = $password_hash;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->identifier;
	}

	/**
	 * @param string $id
	 *
	 * @return $this
	 */
	public function setId($id)
	{
		$this->identifier = $id;

		return $this;
	}
}
