<?php
/**
 * Button элемент формы
 * @file    ButtonElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Авг 15 00:33:35 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс ButtonElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class ButtonElement extends AbstractElement
{
    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        return '<input' . $this->attributes() . 'type="button">';
    }
}
