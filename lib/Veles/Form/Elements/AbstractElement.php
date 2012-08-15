<?php
/**
 * Базовый класс элементов формы
 * @file    AbstractElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 21:52:39 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Класс AbstractElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractElement implements iElement
{
    protected $required;
    protected $validator;
    protected $value;
    protected $name;

    /**
     * Валидация элемента формы
     * @param mixed $value Значение для валидации
     */
    final public function validate($value)
    {
        if ($this->validator->check($value)) {
            $this->value = $value;
            return true;
        }

        return false;
    }

    /**
     * Проверка является ли элемент обязательным
     */
    final public function required()
    {
        return $this->required;
    }

    /**
     * Получение имени элемента
     */
    final public function getName()
    {
        return $this->name;
    }

    /**
     * Отрисовка элемента реализуется для каждого элемента
     */
    abstract public function render();
}
