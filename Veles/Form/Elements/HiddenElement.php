<?php
/**
 * Hidden элемент формы
 * @file    HiddenElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 21:41:53 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс HiddenElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class HiddenElement extends AbstractElement
{
    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        $output = '<input' . $this->attributes() . 'type="hidden">';

        return $output;
    }
}
