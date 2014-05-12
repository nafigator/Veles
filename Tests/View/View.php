<?php
namespace Veles\Tests\View;

class View extends \Veles\View\View
{
	public static function unsetAdapter()
	{
		self::$adapter = null;
	}
}
