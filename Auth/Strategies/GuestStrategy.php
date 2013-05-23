<?php
/**
 * Стратегия гостевой авторизации
 * @file    GuestStrategy,php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 27 21:43:51 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;

/**
 * Класс GuestStrategy
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class GuestStrategy extends AbstractAuthStrategy
{
	/**
	 * Гостевая авторизация
	 * @return bool
	 */
	final public function identify()
	{
		$props = array('group' => UsrGroup::GUEST);
		$this->user->setProperties($props);

		return false;
	}
}
