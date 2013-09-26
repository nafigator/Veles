<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcachedAdapter;

class MemcachedAdapterChild extends MemcachedAdapter
{
    final public function getDriverForTest()
    {
        return $this->driver;
    }

	/**
	 * @return MemcachedAdapterChild
	 */
	final public static function getTestInstance()
	{
		return new self;
	}
}