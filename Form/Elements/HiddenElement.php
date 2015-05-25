<?php
/**
 * Hidden элемент формы
 * @file      HiddenElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Втр Авг 14 21:41:53 2012
 * @copyright The BSD 3-Clause License
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
