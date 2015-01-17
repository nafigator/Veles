<?php
/**
 * Unit-test for UploadFile class
 * @file    TimerTest.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    2013-07-28 21:33:28
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests\Tools;

use PHPUnit_Framework_TestCase;
use ReflectionObject;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-07-28 at 21:33:28.
 */
class UploadFileTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var UploadFile
	 */
	protected $object;

	/**
	 * @covers Veles\Tools\UploadFile::setOrigName
	 * @group Tools
	 * @see UploadFile::setOrigName
	 */
	public function testSetOrigName()
	{
		$this->object->setOrigName('image.jpg');

		$object = new ReflectionObject($this->object);
		$prop = $object->getProperty('orig_name');

		$msg = 'Property UploadFile::$orig_name not protected';
		$this->assertTrue($prop->isProtected(), $msg);

		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$orig_name: $result";
		$this->assertSame('image.jpg', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getOrigName
	 * @group Tools
	 * @depends testSetOrigName
	 * @see UploadFile::getOrigName
	 */
	public function testGetOrigName()
	{
		$this->object->setOrigName('new-image.png');

		$result = $this->object->getOrigName();

		$msg = "Wrong value of UploadFile::\$orig_name: $result";
		$this->assertSame('new-image.png', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::setHash
	 * @group Tools
	 * @see UploadFile::setHash
	 */
	public function testSetHash()
	{
		$this->object->setHash('4b53f83dcef24c5eefa9c9d9633f9ff5');

		$object = new ReflectionObject($this->object);
		$hash_prop = $object->getProperty('hash');

		$msg = 'Property UploadFile::$hash not protected';
		$this->assertTrue($hash_prop->isProtected(), $msg);

		$hash_prop->setAccessible(true);
		$result = $hash_prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$hash: $result";
		$this->assertSame('4b53f83dcef24c5eefa9c9d9633f9ff5', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getHash
	 * @group Tools
	 * @depends testSetHash
	 * @see UploadFile::getHash
	 */
	public function testGetHash()
	{
		$this->object->setHash('4b53f83dcef24c5eefa98889633f9ff5');

		$result = $this->object->getHash();

		$msg = "Wrong value of UploadFile::\$hash: $result";
		$this->assertSame('4b53f83dcef24c5eefa98889633f9ff5', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::setSubDir
	 * @group Tools
	 * @see UploadFile::setSubDir
	 */
	public function testSetSubDir()
	{
		$this->object->setSubDir('aa');

		$object = new ReflectionObject($this->object);
		$sub_dir_prop = $object->getProperty('sub_dir');

		$msg = 'Property UploadFile::$sub_dir_prop not protected';
		$this->assertTrue($sub_dir_prop->isProtected(), $msg);

		$sub_dir_prop->setAccessible(true);
		$result = $sub_dir_prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$sub_dir_prop: $result";
		$this->assertSame('aa', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getSubDir
	 * @group Tools
	 * @depends testSetSubDir
	 * @see UploadFile::getSubDir
	 */
	public function testGetSubDir()
	{
		$this->object->setSubdir('dd');

		$result = $this->object->getSubdir();

		$msg = "Wrong value of UploadFile::\$sub_dir: $result";
		$this->assertSame($result, 'dd', $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::setTmpPath
	 * @group Tools
	 * @see UploadFile::setTmpPath
	 */
	public function testSetTmpPath()
	{
		$this->object->setTmpPath('/tmp/tmp-file893');

		$object = new ReflectionObject($this->object);
		$sub_dir_prop = $object->getProperty('tmp_path');

		$msg = 'Property UploadFile::$tmp_path not protected';
		$this->assertTrue($sub_dir_prop->isProtected(), $msg);

		$sub_dir_prop->setAccessible(true);
		$result = $sub_dir_prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$tmp_path: $result";
		$this->assertSame('/tmp/tmp-file893', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getTmpPath
	 * @group Tools
	 * @depends testSetTmpPath
	 * @see UploadFile::getTmpPath
	 */
	public function testGetTmpPath()
	{
		$this->object->setTmpPath('/tmp/file-path2937');

		$result = $this->object->getTmpPath();

		$msg = "Wrong value of UploadFile::\$tmp_path: $result";
		$this->assertSame($result, '/tmp/file-path2937', $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::initStorageName
	 * @group Tools
	 * @depends testSetHash
	 * @depends testSetSubDir
	 * @depends testSetTmpPath
	 * @see UploadFile::initStorageName
	 */
	public function testInitStorageName()
	{
		// Test for non-empty hash case
		$hash = '4b53f83dcdd24c5eefa9c9d9633f9ff5';
		$this->object->setHash($hash);
		$this->object->initStorageName();

		$object = new ReflectionObject($this->object);
		$prop = $object->getProperty('sub_dir');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$expected = null;

		$msg = 'Wrong value of UploadFile::$sub_dir property';
		$this->assertSame($expected, $result, $msg);

		$prop = $object->getProperty('name');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = 'Not valid value of UploadFile::$name property';
		$this->assertSame($expected, $result, $msg);

		$prop = $object->getProperty('dir');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = 'Wrong value of UploadFile::$dir property';
		$this->assertSame($expected, $result, $msg);

		$prop = $object->getProperty('path');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = 'Not valid value of UploadFile::$path property';
		$this->assertSame($expected, $result, $msg);

		$this->object = new UploadFile;

		// Test for empty hash case
		$content = 'This is the test content';
		$path = tempnam(sys_get_temp_dir(), 'veles-testInitStorageName');
		$this->object->setTmpPath($path);

		file_put_contents($path, $content);

		$this->object->setDir(sys_get_temp_dir());
		$this->object->initStorageName();
		$object = new ReflectionObject($this->object);

		$prop = $object->getProperty('hash');
		$prop->setAccessible(true);
		$hash = $prop->getValue($this->object);

		$msg = 'Not valid value of UploadFile::$hash property';
		$this->assertSame(1, preg_match('/^[a-f0-9]{40}$/', $hash), $msg);

		$expected = hash_file($this->object->getHashAlgorithm(), $path);
		$msg = 'Wrong value of UploadFile::$hash property';
		$this->assertSame($expected, $hash, $msg);

		$prop = $object->getProperty('sub_dir');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$sub_dur = substr($hash, 0, 2);

		$msg = 'Wrong value of UploadFile::$sub_dir property';
		$this->assertSame($sub_dur, $result, $msg);

		$prop = $object->getProperty('name');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$name = substr($hash, 2) . '.';

		$msg = 'Not valid value of UploadFile::$name property';
		$this->assertSame($name, $result, $msg);

		$prop = $object->getProperty('dir');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $sub_dur;

		$msg = 'Wrong value of UploadFile::$dir property';
		$this->assertSame($dir, $result, $msg);

		$prop = $object->getProperty('path');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$path = $dir . DIRECTORY_SEPARATOR . $name;

		$msg = 'Not valid value of UploadFile::$path property';
		$this->assertSame($path, $result, $msg);

		// test file cleanup
		unlink($this->object->getTmpPath());
	}

	/**
	 * @covers Veles\Tools\UploadFile::setDirMask
	 * @group Tools
	 * @see UploadFile::setDirMask
	 */
	public function testSetDirMask()
	{
		$this->object->setDirMask(0744);

		$object = new ReflectionObject($this->object);
		$dir_mask_prop = $object->getProperty('dir_mask');

		$msg = 'Property UploadFile::$tmp_path not protected';
		$this->assertTrue($dir_mask_prop->isProtected(), $msg);

		$dir_mask_prop->setAccessible(true);
		$result = $dir_mask_prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$dir_mask: $result";
		$this->assertSame(0744, $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getDirMask
	 * @group Tools
	 * @see UploadFile::getDirMask
	 */
	public function testGetDirMask()
	{
		$result = $this->object->getDirMask();
		$msg = "Wrong value of UploadFile::\$dir_mask: $result";
		$this->assertSame($result, 0755, $msg);

		$this->object->setDirMask(0644);
		$result = $this->object->getDirMask();
		$this->assertSame($result, 0644, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::setWwwPath
	 * @group Tools
	 * @see UploadFile::setWwwPath
	 */
	public function testSetWwwPath()
	{
		$this->object->setWwwPath('/tmp/tmp-file555');

		$object = new ReflectionObject($this->object);
		$sub_dir_prop = $object->getProperty('www_path');

		$msg = 'Property UploadFile::$www_path not protected';
		$this->assertTrue($sub_dir_prop->isProtected(), $msg);

		$sub_dir_prop->setAccessible(true);
		$result = $sub_dir_prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$www_path: $result";
		$this->assertSame('/tmp/tmp-file555', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getWwwPath
	 * @group Tools
	 * @depends testSetWwwPath
	 * @see UploadFile::getWwwPath
	 */
	public function testGetWwwPath()
	{
		$this->object->setWwwPath('/tmp/file-path4984');

		$result = $this->object->getWwwPath();

		$msg = "Wrong value of UploadFile::\$Www_path: $result";
		$this->assertSame($result, '/tmp/file-path4984', $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::setHashAlgorithm
	 * @group Tools
	 * @see UploadFile::setHashAlgorithm
	 */
	public function testSetHashAlgorithm()
	{
		$this->object->setHashAlgorithm('md5');

		$object = new ReflectionObject($this->object);
		$dir_mask_prop = $object->getProperty('hash_algorithm');

		$msg = 'Property UploadFile::$hash_algorithm not protected';
		$this->assertTrue($dir_mask_prop->isProtected(), $msg);

		$dir_mask_prop->setAccessible(true);
		$result = $dir_mask_prop->getValue($this->object);

		$msg = "Wrong value of UploadFile::\$hash_algorithm: $result";
		$this->assertSame('md5', $result, $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::getHashAlgorithm
	 * @group Tools
	 * @see UploadFile::getHashAlgorithm
	 */
	public function testGetHashAlgorithm()
	{
		$result = $this->object->getHashAlgorithm();
		$msg = "Wrong value of UploadFile::\$hash_algorithm: $result";
		$this->assertSame($result, 'sha1', $msg);

		$this->object->setHashAlgorithm('md5');
		$result = $this->object->getHashAlgorithm();
		$this->assertSame($result, 'md5', $msg);
	}

	/**
	 * @covers Veles\Tools\UploadFile::save
	 * @covers Veles\Tools\UploadFile::moveUploadedFile
	 *
	 * @group Tools
	 * @depends testGetTmpPath
	 * @dataProvider saveProvider
	 * @see UploadFile::save
	 */
	public function testSave($dir, $file, $expected)
	{
		$this->object->setTmpPath($file['tmp_name']);
		$this->object->setOrigName($file['name']);
		$this->object->setDir($dir);

		$this->object->initStorageName();
		$result = $this->object->save();


		$msg = 'Wrong result of UploadFile::save: ' . ($result)
			? 'true' : 'false';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for UploadFileTest::testSave
	 */
	public function saveProvider()
	{
		$files = [];
		$dir = sys_get_temp_dir() . '/VelesUploads';
		$tmp_dir = sys_get_temp_dir();

		for ($i = 0; $i <= 3; ++$i) {
			$files[$i]['tmp_name'] = tempnam($tmp_dir, 'VelesUploads-File');
			$files[$i]['name'] = uniqid('xxx-') . '.txt';
			$_FILES["uploaded_file_$i"]['name'] = $files[$i]['name'];
			$_FILES["uploaded_file_$i"]['tmp_name'] = $files[$i]['tmp_name'];
			$_FILES["uploaded_file_$i"]['size'] = 0;
			$_FILES["uploaded_file_$i"]['type'] = 'plain/text';
			$_FILES["uploaded_file_$i"]['error'] = UPLOAD_ERR_OK;
			file_put_contents(
				$files[$i]['tmp_name'],
				uniqid('This is test content ', true)
			);
		}

		return [
			[$dir, $files[0], true],
			[$dir, $files[1], true],
			[$dir, $files[2], true],
			[$dir, $files[3], true]
		];

	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new UploadFile;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}
}
