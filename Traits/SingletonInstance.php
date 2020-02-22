<?php
/**
 * Instance method for Singleton pattern
 *
 * @file      SingletonInstance.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-12-10 23:09
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Traits;

trait SingletonInstance
{
	/** @var  $this */
	protected static $instance;

	/**
	 * Instance method for any class implements Singleton
	 *
	 * @return $this
	 */
	public static function instance()
	{
		// This line fixes phpunit 5.0.5 "last parenthesis" coverage bug
		if (null === static::$instance) {
			$class = get_called_class();

			static::$instance = new $class;
		}

		return static::$instance;
	}
}
