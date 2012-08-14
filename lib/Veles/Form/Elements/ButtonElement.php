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
     * @param string $name Имя элемента
     * @param mixed $value Значение элемента по-умолчанию
     * @param iValidator $validator Валидатор элемента
     * @param bool $required Является ли элемент обязательным
     */
    final public function __construct($name, $value)
    {
        $this->name      = $name;
        $this->value     = $value;
    }

    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        $output = <<<FORM
<input value="$this->name" type="$this->value">
FORM;

        return $output;
    }
}
