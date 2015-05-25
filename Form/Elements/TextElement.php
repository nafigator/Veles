<?php
/**
 * Text элемент формы
 * @file      TextElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Втр Авг 14 22:00:05 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс TextElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class TextElement extends AbstractElement
{
	/**
	 * Отрисовка элемента
	 */
	public function render()
	{
		return '<input' . $this->attributes() . 'type="text">';
	}
}
