<?php
/**
 * The trait is a part of Observer pattern.
 *
 * Class that uses this trait must implement \SplSubject interface
 *
 * @file      Observable.php
 *
 * PHP version 8.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2013-12-31 15:44
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Traits;

use SplObserver;

/**
 * Trait Observable
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
trait Observable
{
	/** @var SplObserver[] */
	protected $observers = [];

	/**
	 * Add subscriber
	 *
	 * @param SplObserver $observer Подписчик
     *
     * @return void
	 */
	public function attach(SplObserver $observer): void
	{
		$this->observers[] = $observer;
	}

	/**
	 * Remove subscriber
	 *
	 * @param SplObserver $observer Подписчик
     *
     * @return void
	 */
	public function detach(SplObserver $observer): void
	{
		if (false !== ($key = array_search($observer, $this->observers, true))) {
			unset($this->observers[$key]);
		}
	}

	/**
	 * Notify subscribers
     *
     * @return void
	 */
	public function notify(): void
	{
		foreach ($this->observers as $value) {
			/** @noinspection PhpParamsInspection */
			$value->update(/** @scrutinizer ignore-type */$this);
		}
	}
}
