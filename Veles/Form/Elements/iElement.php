<?php
/**
 * Интерфейс элементов формы
 * @file    iElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 05:36:37 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

use \Veles\Form\iForm;

/**
 * Интерфейс iElement
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iElement
{
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
