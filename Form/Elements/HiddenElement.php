<?php
/**
 * Hidden элемент формы
 *
 * @file      HiddenElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Авг 14 21:41:53 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
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
