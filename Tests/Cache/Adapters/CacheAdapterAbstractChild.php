<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\CacheAdapterAbstract;

class CacheAdapterAbstractChild extends CacheAdapterAbstract
{
	/**
	 * Driver initialization placed in adapters constructor
	 */
	protected function __construct()
	{
		$this->driver = new CacheDriver;
	}

	public static function setCalls($calls)
	{
		self::$calls = $calls;
	}

	public static function setInstance($instance)
	{
		self::$instance = $instance;
	}

	public static function getCalls()
	{
		return self::$calls;
	}

	public static function getInstance()
	{
		return self::$instance;
	}
}
