<?php
namespace Veles\Tests\Tools;

use Veles\Tools\PhpToken;
use Veles\Validators\PhpTokenValidator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-03 at 22:07:03.
 * @group tools
 */
class PhpTokenTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PhpToken
	 */
	protected $object;
	private static $content = 'this is test content';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$validator = new PhpTokenValidator;
		$this->object = new PhpToken(self::$content, $validator);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Tools\PhpToken::__construct
	 * @dataProvider constructProvider
	 * @param $token
	 * @param $validator
	 * @param $expected
	 */
	public function testConstruct($token, $validator, $expected)
	{
		$obj = new PhpToken($token, $validator);

		$msg = 'Wrong PhpToken::identifier property value';
		$this->assertAttributeSame($expected[0], 'identifier', $obj, $msg);

		$msg = 'Wrong PhpToken::content property value';
		$this->assertAttributeSame($expected[1], 'content', $obj, $msg);

		$msg = 'Wrong PhpToken::line property value';
		$this->assertAttributeSame($expected[2], 'line', $obj, $msg);
	}

	/**
	 * @return array
	 */
	public function constructProvider()
	{
		$validator = new PhpTokenValidator;

		$token_string = uniqid();
		$token_array = [mt_rand(1, 300), uniqid(), mt_rand()];

		return [
			[
				$token_array,
				$validator,
				$token_array
			],
			[
				$token_string,
				$validator,
				[0, $token_string, 0]
			]
		];
	}

	/**
	 * @expectedException \Exception
	 * @dataProvider constructExceptionProvider
	 * @param $not_valid_token
	 * @param $validator
	 */
	public function testConstructException($not_valid_token, $validator)
	{
		$obj = new PhpToken($not_valid_token, $validator);
	}

	public function constructExceptionProvider()
	{
		return [[mt_rand(), new PhpTokenValidator]];
	}

	/**
	 * @covers Veles\Tools\PhpToken::setContent
	 */
	public function testSetContent()
	{
		$msg = 'Wrong initial value of PhpToken::content';
		$this->assertAttributeSame(self::$content, 'content', $this->object, $msg);

		$expected = uniqid();
		$this->object->setContent($expected);

		$msg = 'Wrong behavior of PhpToken::setContent()';
		$this->assertAttributeSame($expected, 'content', $this->object, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::getContent
	 */
	public function testGetContent()
	{
		$expected = uniqid();
		$this->object->setContent($expected);

		$result = $this->object->getContent();

		$msg = 'Wrong behavior of PhpToken::getContent()';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::setId
	 */
	public function testSetId()
	{
		$expected = mt_rand();
		$this->object->setId($expected);

		$msg = 'Wrong behavior of PhpToken::setId()';
		$this->assertAttributeSame($expected, 'identifier', $this->object, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::getId
	 */
	public function testGetId()
	{
		$expected = mt_rand();
		$this->object->setId($expected);

		$result = $this->object->getId();

		$msg = 'Wrong behavior of PhpToken::getId()';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::setLine
	 */
	public function testSetLine()
	{
		$expected = mt_rand();
		$this->object->setLine($expected);

		$msg = 'Wrong behavior of PhpToken::setLine()';
		$this->assertAttributeSame($expected, 'line', $this->object, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::getLine
	 */
	public function testGetLine()
	{
		$expected = mt_rand();
		$this->object->setLine($expected);

		$result = $this->object->getLine();

		$msg = 'Wrong behavior of PhpToken::getLine()';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::setName
	 */
	public function testSetName()
	{
		$expected = uniqid();
		$this->object->setName($expected);

		$msg = 'Wrong behavior of PhpToken::setName()';
		$this->assertAttributeSame($expected, 'name', $this->object, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::getName
	 */
	public function testGetName()
	{
		$expected = uniqid();
		$this->object->setName($expected);

		$result = $this->object->getName();

		$msg = 'Wrong behavior of PhpToken::getName()';
		$this->assertSame($expected, $result, $msg);
	}
}
