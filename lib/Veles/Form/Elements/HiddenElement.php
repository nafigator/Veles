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
     * Конструктор Hidden элемента
     * @param string $name Имя элемента
     * @param mixed $value Значение элемента по-умолчанию
     * @param iValidator $validator Валидатор элемента
     * @param bool $required Является ли элемент обязательным
     */
    final public function __construct($name, $value, $validator, $required = false)
    {
        $this->name      = $name;
        $this->value     = $value;
        $this->validator = $validator;
        $this->required  = $required;
    }

    /**
     * Отрисовка элемента
     */
    final public function render()
    {
        $output = "<input name=\"{$this->name}\" type=\"hidden\" value={$this->value}>";

        return $output;
    }
}
