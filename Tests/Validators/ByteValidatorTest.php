<?php
/**
 * Unit-test for ByteValidator class
 * @file    ByteValidatorTest.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2013-05-24 07:54
 * @license The BSD 3-Clause License <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Tests\Validators;

use PHPUnit_Framework_TestCase;
use Veles\Validators\ByteValidator;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-05-24 at 07:54:20.
 */
class ByteValidatorTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ByteValidator
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new ByteValidator;
	}

	/**
	 * @covers Veles\Validators\ByteValidator::check
	 * @group  Validators
	 * @see	   ByteValidator::check()
	 * @dataProvider checkProvider
	 */
	public function testCheck($size, $expected)
	{
		$result = $this->object->check($size);

		$msg = 'Wrong ByteValidator::check() validation';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * Data-provider for testCheck
	 */
	public function checkProvider()
	{
		return [
			[123, true],
			[500, true],
			[-1298, true],
			[23.34, true],
			['one', false],
			['23', true]
		];
	}

	/**
	 * @covers Veles\Validators\ByteValidator::format
	 * @group  Validators
	 * @see	   ByteValidator::format()
	 * @dataProvider formatProvider
	 */
	public function testFormat($size, $expected)
	{
		$result = $this->object->format($size);

		$msg = 'Wrong ByteValidator::format() result';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * Data-provider for testFormat
	 */
	public function formatProvider()
	{
		return [
			[58, '58.00 B'],
			[10245, '10.00 KB'],
			[10245156, '9.77 MB'],
			[10485760, '10.00 MB'],
			[10737418240, '10.00 GB']
		];
	}
}
