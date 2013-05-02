<?php
/**
 * TextArea элемент формы
 * @file    TextAreaElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Ноя 10 12:14:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

/**
 * Класс TextAreaElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class TextAreaElement extends AbstractElement
{
    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        return '<textarea' . $this->attributes() . ">$this->value</textarea>";
    }
}
