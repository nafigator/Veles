<?php
/**
 * Text элемент формы
 *
 * @file      TextElement.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Втр Авг 14 22:00:05 2012
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
