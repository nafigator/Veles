<?php
/**
 * @file    ApcAdapterChild.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    2014-10-31 21:49
 * @copyright The BSD 3-Clause License
 */

namespace Tests\Cache\Adapters;

use Veles\Cache\Adapters\ApcAdapter;

/**
 * Class ApcAdapterChild
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class ApcAdapterChild extends ApcAdapter
{
	public function getDriverForTest()
	{
		return $this->driver;
	}

	/**
	 * @return ApcAdapterChild
	 */
	public static function getTestInstance()
	{
		return new self;
	}
}
