<?php
/**
 * HTTP Base authentication strategy
 *
 * @file      HttpBasic.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-01-20 21:21
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest\AuthStrategies;

use Veles\CurlRequest\CurlRequest;

/**
 * Class HttpBasic
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class HttpBasic implements AuthStrategyInterface
{
	protected $login;
	protected $password;

	/**
	 * Sets headers for request for further authentication
	 *
	 * @param CurlRequest $request
	 *
	 * @return $this
	 */
	public function apply(CurlRequest $request)
	{
		$headers = $request->getHeaders();
		$hash = base64_encode($this->getLogin() . ':' . $this->getPassword());
		$headers[] = "Authorization: Basic $hash";

		$request->setHeaders($headers);

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get login
	 *
	 * @return string
	 */
	public function getLogin()
	{
		return $this->login;
	}

	/**
	 * Set login
	 *
	 * @param string $login
	 *
	 * @return $this
	 */
	public function setLogin($login)
	{
		$this->login = $login;

		return $this;
	}
}
