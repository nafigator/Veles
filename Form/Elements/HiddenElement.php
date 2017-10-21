<?php
/**
 * Hidden элемент формы
 *
 * @file      HiddenElement.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Втр Авг 14 21:41:53 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Form\Elements;

/**
 * Класс HiddenElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class HiddenElement extends AbstractElement
{
	/**
	 * Отрисовка элемента
	 */
	public function render()
	{
		return '<input' . $this->attributes() . 'type="hidden">';
	}
}
