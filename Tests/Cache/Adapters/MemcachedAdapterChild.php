<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcachedAdapter;

class MemcachedAdapterChild extends MemcachedAdapter
{
	public function getDriverForTest()
	{
		return $this->driver;
	}

	/**
	 * @return MemcachedAdapterChild
	 */
	public static function getTestInstance()
	{
		return new self;
	}
}
