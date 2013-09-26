<?php
namespace Veles\Tests\Cache\Adapters;

class CacheDriver
{
    final public function testCall($param)
    {
        return is_string($param);
    }
}