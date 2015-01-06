<?php
/**
 * @file    BaseAuthStrategy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2015-01-06 14:45
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Auth\Strategies;

/**
 * Class BaseAuthStrategy
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class BaseAuthStrategy extends AbstractAuthStrategy
{
	/**
	 * Constructor
	 */
	public function __construct($login, $password)
	{
		$this->login    = $login;
		$this->password = $password;
	}
}
