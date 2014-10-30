<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcacheAdapter;

class MemcacheAdapterChild extends MemcacheAdapter
{
	public function getDriverForTest()
	{
		return $this->driver;
	}

	/**
	 * @return MemcacheAdapterChild
	 */
	public static function getTestInstance()
	{
		return new self;
	}
}
