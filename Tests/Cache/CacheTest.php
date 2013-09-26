<?php
namespace Veles\Tests\Cache;

use PHPUnit_Framework_TestCase;
use Veles\Tests\Cache\Cache;
use ReflectionObject;
use Veles\Cache\Adapters\iCacheAdapter;
use Memcached;
use Exception;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-02 at 17:46:39.
 */
class CacheTest extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        Cache::setAdapter('Memcache');
    }

    public static function tearDownAfterClass()
    {
        Cache::setAdapter();
    }

	/**
	 * @covers OpenRu\Core\Cache\Cache::setAdapter
	 * @dataProvider setAdapterProvider
	 */
	public function testSetAdapter($class_name)
	{
		if ('' === $class_name) {
			Cache::setAdapter();
			$expected = "\\Veles\\Cache\\Adapters\\ApcAdapter";
		} else {
			Cache::setAdapter($class_name);
			$expected = "\\Veles\\Cache\\Adapters\\${class_name}Adapter";
		}

		$object = new ReflectionObject(new Cache);

		$prop = $object->getProperty('adapter_name');
		$prop->setAccessible(true);
		$result = $prop->getValue();

		$msg = 'Wrong Cache::$adapter_name property value!';
		$this->assertSame($expected, $result, $msg);

		$prop = $object->getProperty('adapter');
		$prop->setAccessible(true);
		$result = $prop->getValue();
		$expected = null;

		$msg = 'Wrong Cache::$adapter property value!';
		$this->assertSame($expected, $result, $msg);
	}

	public function setAdapterProvider()
	{
		return array(
			array(''),
			array('Memcache'),
			array('Memcached')
		);
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::getAdapter
	 * @depends testSetAdapter
	 */
	public function testGetAdapter()
	{
		Cache::resetAdapter();
		$result = Cache::getAdapter();

		$this->assertTrue($result instanceof iCacheAdapter);

		Cache::setAdapter('Memcached');
		$result = Cache::getAdapter();

		$this->assertTrue($result instanceof iCacheAdapter);
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::getAdapter
	 * @expectedException Exception
	 */
	public function testSetAdapterException()
	{
		Cache::unsetAdapter();
		Cache::getAdapter();
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::get
	 * @depends testSetAdapter
	 * @depends testGetAdapter
	 * @dataProvider getProvider
	 */
	public function testGet($key, $expected)
	{
		Cache::setAdapter('Memcache');
		$result = Cache::get($key);

		$msg = 'Wrong Cache::get result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function getProvider()
	{
		$cache = new Memcached;
		$cache->addServer('localhost', 11211);
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('RBK::UNIT-TEST::');
			$value = uniqid();
			$cache->set($key, $value, 10);
			$params[] = array($key, $value);
		}

		return $params;
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::set
	 * @depends testSetAdapter
	 * @depends testGetAdapter
	 */
	public function testSet()
	{
		$key = uniqid('RBK::UNIT-TEST::');
		$expected = uniqid();
		Cache::set($key, $expected, 10);

		$cache = new Memcached;
		$cache->addServer('localhost', 11211);
		$result = $cache->get($key);

		$msg = 'Wrong Cache::set result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::has
	 * @depends testSet
	 */
	public function testHas()
	{
		$key = uniqid('RBK::UNIT-TEST::');
		$value = uniqid();
		Cache::set($key, $value, 10);

		$result = Cache::has($key);

		$msg = 'Wrong Cache::has result!';
		$this->assertSame(true, $result, $msg);
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::del
	 * @depends testSet
	 */
	public function testDel()
	{
		$key = uniqid('RBK::UNIT-TEST::');
		$value = uniqid();
		Cache::set($key, $value, 10);

		$result = Cache::del($key);

		$msg = 'Wrong Cache::del result!';
		$this->assertSame(true, $result, $msg);

		$result = Cache::has($key);

		$msg = 'Cache value wasn\'t deleted!';
		$this->assertSame(false, $result, $msg);
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::increment
	 * @dataProvider incrementProvider
	 * @depends testSet
	 */
	public function testIncrement($key, $offset, $expected)
	{
		$result = (null === $offset)
			? Cache::increment($key)
			: Cache::increment($key, $offset);

		$msg = 'Cache::increment returned wrong result type!';
		$this->assertInternalType('integer', $result, $msg);
		$msg = 'Cache::increment returned wrong result value!';
		$this->assertSame($expected, $result, $msg);
	}

	public function incrementProvider()
	{
		// for default offset testing
		$key    = uniqid('RBK::UNIT-TEST::');
		$value  = mt_rand(0, 1000);
		Cache::set($key, $value, 10);
		$params = array(array($key, null, ++$value));

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('RBK::UNIT-TEST::');
			$value  = mt_rand(0, 1000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = array($key, $offset, $value + $offset);
		}

		return $params;
	}

	/**
	 * @covers OpenRu\Core\Cache\Cache::decrement
	 * @dataProvider decrementProvider
	 * @depends testSet
	 */
	public function testDecrement($key, $offset, $expected)
	{
		$result = (null === $offset)
			? Cache::decrement($key)
			: Cache::decrement($key, $offset);

		$msg = 'Cache::decrement returned wrong result type!';
		$this->assertInternalType('integer', $result, $msg);
		$msg = 'Cache::decrement returned wrong result value!';
		$this->assertSame($expected, $result, $msg);
	}

	public function decrementProvider()
	{
		// for default offset testing
		$key    = uniqid('RBK::UNIT-TEST::');
		$value  = mt_rand(1, 1000);
		Cache::set($key, $value, 10);
		$params = array(array($key, null, --$value));

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('RBK::UNIT-TEST::');
			$value  = mt_rand(1000, 2000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = array($key, $offset, $value - $offset);
		}

		return $params;
	}

//	/**
//	 * @covers OpenRu\Core\Cache\Cache::clear
//	 * @depends testSet
//	 */
//	public function testClear()
//	{
//		$params = array();
//
//		for ($i = 0; $i < 10; ++$i) {
//			$key = uniqid('RBK::UNIT-TEST::');
//			$value = uniqid();
//			Cache::set($key, $value, 10);
//			$params[] = $key;
//		}
//
//		$result = Cache::clear();
//
//		$msg = 'Wrong Cache::clear() result!';
//		$this->assertSame(true, $result, $msg);
//
//		$result = false;
//		foreach ($params as $key) {
//			if (Cache::has($key)) $result = true;
//		}
//
//		$msg = 'Cache was not cleared!';
//		$this->assertSame(false, $result, $msg);
//	}
}