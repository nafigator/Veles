<?php
/**
 * Submit-кнопка формы
 * @file      SubmitElement.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Сбт Авг 18 21:36:33 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс SubmitElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class SubmitElement extends AbstractElement
{
	/**
	 * Отрисовка элемента
	 */
	public function render()
	{
		return '<input' . $this->attributes() . 'type="submit">';
	}
}
