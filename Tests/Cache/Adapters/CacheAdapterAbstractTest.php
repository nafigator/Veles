<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Cache;
use Exception;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-03 at 16:52:22.
 */
class CacheAdapterAbstractTest extends \PHPUnit_Framework_TestCase
{
	private static $driver;

	public static function setUpBeforeClass()
	{
		self::$driver = CacheAdapterAbstractChild::instance()->getDriver();
	}

	public static function tearDownAfterClass()
	{
		CacheAdapterAbstractChild::instance()->setDriver(self::$driver);
	}

	/**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::setDriver
	 */
	public function testSetDriver()
	{
		$expected = 'uq[0n;34nt';
		$obj = CacheAdapterAbstractChild::instance();
		$obj->setDriver($expected);

		$msg = 'Wrong behavior of CacheAdapterAbstract::setDriver()';
		$this->assertAttributeSame($expected, 'driver', $obj, $msg);
	}

	/**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::getDriver
	 * @depends testSetDriver
	 */
	public function testGetDriver()
	{
		$expected = '123;kbn90bj';
		$obj = CacheAdapterAbstractChild::instance();
		$obj->setDriver($expected);

		$result = $obj->getDriver();
		$msg = 'Wrong result of CacheAdapterAbstract::getDriver()';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::instance
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::invokeLazyCalls
	 */
	public function testInstance()
	{
		$expected = __NAMESPACE__ . '\CacheAdapterAbstractChild';
		CacheAdapterAbstractChild::setInstance(null);
		CacheAdapterAbstractChild::setCalls(null);
		$result = CacheAdapterAbstractChild::instance();

		$msg = 'Adapter returned wrong instance object!';
		$this->assertInstanceOf($expected, $result, $msg);

		CacheAdapterAbstractChild::setInstance(null);
		CacheAdapterAbstractChild::setCalls(array(array(
			'method'    => 'testCall',
			'arguments' => array('string')
		)));

		$result = CacheAdapterAbstractChild::instance();

		$msg = 'Adapter returned wrong instance object!';
		$this->assertInstanceOf($expected, $result, $msg);

		$result = CacheAdapterAbstractChild::getCalls();
		$this->assertSame(null, $result);

		Cache::setAdapter();
	}

	/**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::AddCall
	 */
	public function testAddCall()
	{
		CacheAdapterAbstractChild::addCall('testCall', array('string'));

		$result = CacheAdapterAbstractChild::getCalls();
		$expected = array(array(
			'method' => 'testCall',
			'arguments' => array('string')
		));

		$msg = 'Driver calls was not saved correctly!';
		$this->assertSame($expected, $result, $msg);
	}
}
