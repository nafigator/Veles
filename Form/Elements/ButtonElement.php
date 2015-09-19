<?php
/**
 * Button элемент формы
 *
 * @file      ButtonElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Срд Авг 15 00:33:35 2012
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Form\Elements;

/**
 * Класс ButtonElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class ButtonElement extends AbstractElement
{
	/**
	 * Отрисовка элемента
	 */
	public function render()
	{
		return '<input' . $this->attributes() . 'type="button">';
	}
}
