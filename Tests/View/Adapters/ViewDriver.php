<?php
/**
 * @file    ViewDriver.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-19 16:23
 * @license The BSD 3-Clause License <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Tests\View\Adapters;

/**
 * Class ViewDriver
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ViewDriver
{
	public function testExec($params)
	{
		return is_string($params);
	}
}
