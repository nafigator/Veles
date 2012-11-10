<?php
/**
 * Submit-кнопка формы
 * @file    SubmitElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Авг 18 21:36:33 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс SubmitElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class SubmitElement extends AbstractElement
{
    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        return '<input' . $this->attributes() . 'type="submit">';
    }
}
