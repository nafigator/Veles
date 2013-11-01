<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcacheRaw;

class MemcacheRawChild extends MemcacheRaw
{
	public function getConnection()
	{
		return $this->connection;
	}

	public function getHost()
	{
		return self::$host;
	}

	public function getPort()
	{
		return self::$port;
	}
}