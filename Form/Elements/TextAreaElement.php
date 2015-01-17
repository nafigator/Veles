<?php
/**
 * TextArea элемент формы
 * @file    TextAreaElement.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Сбт Ноя 10 12:14:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс TextAreaElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class TextAreaElement extends AbstractElement
{
	/**
	 * Отрисовка элемента
	 */
	public function render()
	{
		return '<textarea' . $this->attributes() . ">$this->value</textarea>";
	}
}
