<?php
/**
 * Interface for Singleton functionality
 *
 * @file      SingletonInstanceInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-03-05 18:45
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Traits;

interface SingletonInstanceInterface
{
	/**
	 * Instance method for any class implements Singleton
	 *
	 * @return $this
	 */
	public static function instance();
}
