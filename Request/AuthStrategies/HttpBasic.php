<?php
/**
 * @file    HttpBasic.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-01-20 21:21
 * @copyright The BSD 3-Clause License
 */

namespace Request\AuthStrategies;

use Request\CurlRequest;

/**
 * Class HttpBasic
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class HttpBasic implements iAuthStrategy
{
	protected $login;
	protected $password;

	/**
	 * Sets headers for request for further authentication
	 *
	 * @param CurlRequest $request
	 *
	 * @return bool
	 */
	public function apply(CurlRequest $request)
	{
		$headers = $request->getRequestHeaders();
		$hash = base64_encode($this->getLogin() . ':' . $this->getPassword());
		$headers[] = "Authorization: Basic $hash";

		$request->setRequestHeaders($headers);
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
