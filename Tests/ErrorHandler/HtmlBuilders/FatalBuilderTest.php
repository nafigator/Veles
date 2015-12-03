<?php
namespace Veles\Tests\ErrorHandler\HtmlBuilders;

use Veles\ErrorHandler\FatalErrorHandler;
use Veles\ErrorHandler\HtmlBuilders\FatalBuilder;
use Veles\ErrorHandler\Subscribers\ErrorRenderer;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-06 at 08:31:11.
 * @group error-handler
 */
class FatalBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var FatalBuilder
	 */
	protected $object;
	protected $message = 'FATAL ERROR!';
	protected $html;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new FatalBuilder;
		$this->html = <<<EOL
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	$this->message</body>
</html>

EOL;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		restore_error_handler();
		ini_set('display_errors', 1);
	}

	/**
	 * Hack method for testing fatal error case
	 *
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 * @param $errcontext
	 *
	 * @return bool
	 */
	public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		return false;
	}

	/**
	 * @covers Veles\ErrorHandler\HtmlBuilders\FatalBuilder::getHtml
	 */
	public function testGetHtml()
	{
		set_error_handler(array($this, 'errorHandler'));
		ini_set('display_errors', 0);

		trigger_error($this->message, E_USER_WARNING);
		$handler = new FatalErrorHandler;

		$this->object->setTemplate('Errors/exception.phtml');
		$this->object->setHandler($handler);
		$renderer = new ErrorRenderer;
		$renderer->setMessageBuilder($this->object);

		$this->expectOutputString($this->html);

		$handler->attach($renderer);
		$handler->run();
	}
}