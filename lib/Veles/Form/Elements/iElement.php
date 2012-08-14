<?php
/**
 * Интерфейс элементов формы
 * @file    iElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 05:36:37 2012
 * @version
 */

namespace Veles\Form\Elements;

/**
 * Интерфейс iElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iElement
{
    /**
     * Конструктор
     */
    public function __construct($name, $value, $validator, $required = false);

    /**
     * Валидация элемента формы
     * @param mixed $value Значение для валидации
     */
    public function validate($value);

    /**
     * Проверка является ли элемент обязательным
     */
    public function required();

    /**
     * Получение имени элемента
     */
    public function getName();

    /**
     * Отрисовка элемента
     */
    public function render();
}
