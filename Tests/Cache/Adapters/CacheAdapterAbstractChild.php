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

    final public static function setCalls($calls)
    {
        self::$calls = $calls;
    }

    final public static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    final public static function getCalls()
    {
        return self::$calls;
    }

    final public static function getInstance()
    {
        return self::$instance;
    }
}