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

use \Veles\Form\iForm;

/**
 * Класс AbstractElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
abstract class AbstractElement implements iElement
{
    protected $params;

    /**
     * Конструктор элемента
     * @param array $params Массив параметров элемента формы
     */
    final public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Валидация элемента формы
     * @param mixed $value Значение для валидации
     */
    final public function validate($value)
    {
        if ($this->validator->check($value)) {
            $this->params['attributes']['value'] = $value;
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
        return $this->attributes['name'];
    }

    /**
     * Отрисовка элемента реализуется для каждого элемента
     */
    abstract public function render();

    /**
     * Магия для создания свойств элемента
     * @param stirng $name
     * @param mixed  $value
     */
    final public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Магия для доступа к свойствам элемента
     * @param string $name
     */
    final public function __get($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
    }

    /**
     * Рендеринг аттрибутов элемента
     */
    final public function attributes()
    {
        $attributes = ' ';

        if (!isset($this->params['attributes'])) {
            return $attributes;
        }

        foreach ($this->params['attributes'] as $name => $value) {
            $attributes .= " $name=\"$value\" ";
        }

        return $attributes;
    }
}
