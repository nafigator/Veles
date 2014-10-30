<?php
/**
 * Text элемент формы
 * @file    TextElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 14 22:00:05 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс TextElement
 * @author  Alexander Yancharuk <alex@itvault.info>
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
