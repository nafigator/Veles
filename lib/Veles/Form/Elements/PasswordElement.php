<?php
/**
 * Password элемент формы
 * @file    PasswordElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Срд Авг 15 22:35:36 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс PasswordElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class PasswordElement extends AbstractElement
{
    /**
     * Конструктор Hidden элемента
     * @param string $name Имя элемента
     * @param mixed $value Значение элемента по-умолчанию
     * @param iValidator $validator Валидатор элемента
     * @param bool $required Является ли элемент обязательным
     */
    final public function __construct($name, $value, $validator, $required = true)
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
        $output = "<input name=\"{$this->name}\" type=\"password\" value={$this->value}>";

        return $output;
    }
}
