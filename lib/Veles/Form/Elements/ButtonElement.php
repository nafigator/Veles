<?php
/**
 * Button элемент формы
 * @file    ButtonElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Авг 15 00:33:35 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс ButtonElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class ButtonElement extends AbstractElement
{
    /**
     * Конструктор Button элемента
     * @param string $value Надпись на кнопке
     * @param string $type Тип кнопки
     * @param iValidator $validator Валидатор элемента
     * @param bool $required Является ли элемент обязательным
     */
    final public function __construct($value, $type)
    {
        $this->value = $value;
        $this->type  = $type;
    }

    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        $output = <<<FORM
<input value="$this->value" type="$this->type">
FORM;

        return $output;
    }
}
