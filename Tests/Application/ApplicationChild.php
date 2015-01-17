<?php
/**
 * @file    ApplicationChild.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-11-01 20:27
 * @copyright The BSD 3-Clause License
 */

namespace Application;

use Veles\Application\Application;


/**
 * Class ApplicationChild
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ApplicationChild extends Application
{
	public static function phpSettings($params)
	{
		parent::setPhpSettings($params);
	}
}
