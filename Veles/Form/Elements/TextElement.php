<?php
/**
 * Text элемент формы
 * @file    TextElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 22:00:05 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс TextElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class TextElement extends AbstractElement
{
    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        return '<input' . $this->attributes() . 'type="text">';
    }
}
