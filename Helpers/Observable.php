<?php
/**
 * Class is a part of Observer pattern
 *
 * @file      PdoAdapter.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2013-12-31 15:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Helpers;

use SplObserver;
use SplSubject;

/**
 * Class Observable
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class Observable implements SplSubject
{
	/** @var SplObserver[] */
	protected $observers = [];

	/**
	 * Добавление подписчика
	 *
	 * @param SplObserver $observer Подписчик
	 */
	public function attach(SplObserver $observer)
	{
		$this->observers[] = $observer;
	}

	/**
	 * Удаление подписчика
	 *
	 * @param SplObserver $observer Подписчик
	 */
	public function detach(SplObserver $observer)
	{
		if (false !== ($key = array_search($observer, $this->observers, true))) {
			unset($this->observers[$key]);
		}
	}

	/**
	 * Уведомление подписчиков
	 */
	public function notify()
	{
		foreach ($this->observers as $value) {
			$value->update($this);
		}
	}
}
