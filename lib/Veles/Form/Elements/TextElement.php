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
        $output = "<input name=\"{$this->name}\" type=\"text\" value={$this->value}>";

        return $output;
    }
}
