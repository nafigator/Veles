<?php
/**
 * Стратегия гостевой авторизации
 *
 * @file      GuestStrategy,php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 21:43:51 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;

/**
 * Класс GuestStrategy
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class GuestStrategy extends AbstractAuthStrategy
{
	/**
	 * Гостевая авторизация
	 * @return bool
	 */
	public function identify()
	{
		$props = ['group' => UsrGroup::GUEST];
		$this->user->setProperties($props);

		return false;
	}
}
