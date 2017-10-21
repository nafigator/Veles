<?php
/**
 * TextArea элемент формы
 *
 * @file      TextAreaElement.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Сбт Ноя 10 12:14:37 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
