<?php
namespace Veles\Tests\Helpers;

use SplSubject;

/**
 * Class FakeStmt
 *
 * Нужен для тестирования класса Observable
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @group helpers
 */
class ClassForTesting implements \SplObserver
{
	public $flag;

	public function update(SplSubject $subject)
	{
		$this->flag = true;
	}
}