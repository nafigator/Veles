<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcacheAdapter;

class MemcacheAdapterChild extends MemcacheAdapter
{
    final public function getDriverForTest()
    {
        return $this->driver;
    }

	/**
	 * @return MemcacheAdapterChild
	 */
	final public static function getTestInstance()
	{
		return new self;
	}
}