<?php
/**
 * Unit-test for AutoLoader class
 * @file      AutoLoaderTest.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Вск Янв 20 22:07:49 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests;

use PHPUnit_Framework_TestCase;
use Veles\AutoLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 21:31:21.
 * @group RootClasses
 */
class AutoLoaderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for AutoLoader::init
	 * @group RootClasses
	 * @covers Veles\AutoLoader::init
	 * @see    Veles\AutoLoader::init
	 */
	public function testInit()
	{
		// Удаляем автолоадер из списка зарегистрированных
		spl_autoload_unregister('Veles\AutoLoader::load');

		AutoLoader::init();

		$auto_loaders = spl_autoload_functions();
		$result = array_search(
			['Veles\AutoLoader', 'load'],
			$auto_loaders
		);

		$msg = 'AutoLoader function not registered!';
		$this->assertNotSame(false, $result, $msg);
		$this->assertInternalType('integer', $result, $msg);
	}

	/**
	 * Unit-test for AutoLoader::load
	 * @group RootClasses
	 * @covers Veles\AutoLoader::load
	 * @see    AutoLoader::load()
	 */
	public function testLoad()
	{
		AutoLoader::load('Veles\Tests\AutoLoaderFake');

		$result = array_search('Veles\Tests\AutoLoaderFake', get_declared_classes());

		$msg = 'Class AutoLoaderFake did not loaded';
		self::assertTrue(false !== $result, $msg);
	}

	/**
	 * @covers Veles\AutoLoader::registerPath
	 * @dataProvider registerPathProvider
	 */
	public function testRegisterPath($path)
	{
		$includes = get_include_path();
		if (is_array($path)) {
			foreach ($path as $value) {
				$includes = str_replace($value . PATH_SEPARATOR, '', $includes);
			}
		} else {
			$includes = str_replace($path . PATH_SEPARATOR, '', $includes);
		}

		AutoLoader::registerPath($path);

		if (is_array($path)) {
			$path = implode(PATH_SEPARATOR, $path);
		}

		$expected = true;
		$result = (bool) strstr(get_include_path(), $path);

		$msg = 'Wron AutoLoader::registerPath behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	public function registerPathProvider()
	{
		return [
			[LIB_DIR],
			[[LIB_DIR, TEST_DIR]]
		];
	}
}
