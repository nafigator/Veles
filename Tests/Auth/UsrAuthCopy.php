<?php
/**
 * @file    UsrAuthCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-12-24 16:47
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tests\Auth;

use Veles\Auth\UsrAuth;

/**
 * Class UsrAuthCopy
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class UsrAuthCopy extends UsrAuth
{
	protected static $instance;

	public static function unsetInstance()
	{
		static::$instance = null;
	}
}
