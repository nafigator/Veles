<?php
namespace Veles\Helpers;

use SplSubject;
use SplObserver;

/**
 * Class Observable
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Observable implements SplSubject
{
	/** @var SplObserver[] */
	protected $observers = array();

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