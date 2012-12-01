<?php
/**
 * Select элемент формы
 * @file    SelectElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Чтв Ноя 29 22:09:01 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс SelectElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class SelectElement extends AbstractElement
{
    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        $html  = '<select' . $this->attributes() . '>';

        foreach ($this->options as $option) {
            $selected = '';

            if ($option['id'] == $this->selected)
                $selected = ' selected="true" ';

            $html .= "<option $selected value=\"$option[id]\">$option[name]</option>";
        }

        $html .= '</select>';

        return $html;
    }
}
