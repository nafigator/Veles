<?php
/**
 * Password элемент формы
 * @file    PasswordElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Авг 15 22:35:36 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс PasswordElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class PasswordElement extends AbstractElement
{
	/**
	 * Отрисовка элемента
	 */
	final public function render()
	{
		return '<input' . $this->attributes() . 'type="text">';
	}
}
