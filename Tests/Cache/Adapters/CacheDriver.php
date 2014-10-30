<?php
namespace Veles\Tests\Cache\Adapters;

class CacheDriver
{
	public function testCall($param)
	{
		return is_string($param);
	}
}
