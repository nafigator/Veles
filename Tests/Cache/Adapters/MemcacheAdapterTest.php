<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Tests\Cache\Adapters\MemcacheAdapterChild;
use Veles\Cache\Adapters\MemcacheAdapter;
use Veles\Cache\Cache;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-06 at 15:06:37.
 */
class MemcacheAdapterTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @var MemcacheAdapter
     */
    protected $object;

	public static function setUpBeforeClass()
	{
		Cache::setAdapter('Memcache');
	}

	public static function tearDownAfterClass()
	{
		Cache::setAdapter();
	}

	/**
	 * For each test set up adapter
	 */
	public function setUp()
	{
		$this->object = Cache::getAdapter();
	}

	/**
	 * @covers Veles\Tests\Cache\MemcacheAdapter::__construct
	 */
	public function testInstance()
	{
		$object = MemcacheAdapterChild::getTestInstance();
		$result = $object->getDriverForTest();
		$expected = 'Memcache';
		$msg = 'Wrong result driver inside MemcacheAdapter!';
		$this->assertInstanceOf($expected, $result, $msg);
	}

	/**
     * @covers Veles\Tests\Cache\MemcacheAdapter::get
     * @dataProvider getProvider
     */
    public function testGet($key, $expected)
    {
		$result = $this->object->get($key);
		$msg = 'Wrong MemcacheAdapter::get result!';
		$this->assertSame($expected, $result, $msg);
    }

	public function getProvider()
	{
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('RBK::UNIT-TEST::');
			$value = uniqid();
			Cache::getAdapter()->set($key, $value, 10);
			$params[] = array($key, $value);
		}

		return $params;
	}

    /**
     * @covers Veles\Tests\Cache\MemcacheAdapter::set
     */
    public function testSet()
    {
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('RBK::UNIT-TEST::');
			$value = uniqid();
			$this->object->set($key, $value, 10);
			$params[] = array($key, $value);
		}

		$msg = 'Wrong MemcacheAdapter::set result!';
		foreach ($params as $param) {
			$result = $this->object->get($param[0]);
			$this->assertSame($param[1], $result, $msg);
		}
    }

    /**
     * @covers Veles\Tests\Cache\MemcacheAdapter::has
     * @dataProvider hasProvider
     */
    public function testHas($key, $expected)
    {
		$result = $this->object->has($key);
		$msg = 'Wrong MemcacheAdapter::has result!';
		$this->assertSame($expected, $result, $msg);
    }

	public function hasProvider()
	{
		$params = array();

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('RBK::UNIT-TEST::');
			$value = uniqid();
			Cache::getAdapter()->set($key, $value, 10);
			$params[] = array($key, true);
		}

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('RBK::UNIT-TEST::');
			$params[] = array($key, false);
		}

		return $params;
	}

    /**
     * @covers Veles\Tests\Cache\MemcacheAdapter::del
     * @dataProvider hasProvider
     */
    public function testDel($key, $expected)
    {
		$result = $this->object->del($key);
		$msg = 'Wrong MemcacheAdapter::del result!';
		$this->assertSame($expected, $result, $msg);
    }

    /**
     * @covers Veles\Tests\Cache\MemcacheAdapter::increment
     * @dataProvider incrementProvider
     */
    public function testIncrement($key, $offset, $expected)
    {
		$result = (null === $offset)
			? Cache::getAdapter()->increment($key, 1)
			: Cache::getAdapter()->increment($key, $offset);

		$msg = 'MemcacheAdapter::increment returned wrong result type!';
		$this->assertInternalType('integer', $result, $msg);
		$msg = 'MemcacheAdapter::increment returned wrong result value!';
		$this->assertSame($expected, $result, $msg);
    }

	public function incrementProvider()
	{
		$key    = uniqid('RBK::UNIT-TEST::');
		$value  = mt_rand(0, 1000);
		Cache::getAdapter()->set($key, $value, 10);
		$params = array(array($key, null, ++$value));

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('RBK::UNIT-TEST::');
			$value  = mt_rand(0, 1000);
			$offset = mt_rand(0, 1000);
			Cache::getAdapter()->set($key, $value, 10);
			$params[] = array($key, $offset, $value + $offset);
		}

		return $params;
	}

    /**
     * @covers Veles\Tests\Cache\MemcacheAdapter::decrement
     * @dataProvider decrementProvider
     */
    public function testDecrement($key, $offset, $expected)
    {
		$result = (null === $offset)
			? $this->object->decrement($key, 1)
			: $this->object->decrement($key, $offset);

		$msg = 'MemcacheAdapter::decrement returned wrong result type!';
		$this->assertInternalType('integer', $result, $msg);
		$msg = 'MemcacheAdapter::decrement returned wrong result value!';
		$this->assertSame($expected, $result, $msg);
    }

	public function decrementProvider()
	{
		$key    = uniqid('RBK::UNIT-TEST::');
		$value  = mt_rand(1, 1000);
		Cache::getAdapter()->set($key, $value, 10);
		$params = array(array($key, null, --$value));

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('RBK::UNIT-TEST::');
			$value  = mt_rand(1000, 2000);
			$offset = mt_rand(0, 1000);
			Cache::getAdapter()->set($key, $value, 10);
			$params[] = array($key, $offset, $value - $offset);
		}

		return $params;
	}

	/**
     * @fixme If this test enabled all other cache test throws exception
     *
	 * @covers Veles\Tests\Cache\MemcacheAdapter::clear
	 */
//	public function testClear()
//	{
//		$params = array();
//
//		for ($i = 0; $i < 10; ++$i) {
//			$key = uniqid('RBK::UNIT-TEST::');
//			$value = uniqid();
//			$this->object->set($key, $value, 10);
//			$params[] = $key;
//		}
//
//		$result = $this->object->clear();
//
//		$msg = 'Wrong MemcacheAdapter::clear() result!';
//		$this->assertSame(true, $result, $msg);
//
//		$result = false;
//		foreach ($params as $key) {
//			if ($this->object->get($key)) $result = true;
//		}
//
//		$msg = 'Cache was not cleared!';
//		$this->assertSame(false, $result, $msg);
//	}
}