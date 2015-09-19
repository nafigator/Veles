<?php
/**
 * @file    UsrAuthCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-24 16:47
 * @license The BSD 3-Clause License <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Tests\Auth;

use Veles\Auth\UsrAuth;

/**
 * Class UsrAuthCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UsrAuthCopy extends UsrAuth
{
	protected static $instance;

	public static function unsetInstance()
	{
		static::$instance = null;
	}
}
