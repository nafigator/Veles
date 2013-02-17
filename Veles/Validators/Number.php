<?php
/**
 * Валидатор численных значений формы
 * @file    Number.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Ноя 18 12:48:50 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Validators;

/**
 * Класс Number
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Number implements iValidator
{
    private $max;
    private $min;

    /**
     * Конструктор
     * @param int $max Максимальное значение
     * @param int $min Минимальное значение
     */
    final public function __construct($min = 1, $max = 2147483647)
    {
        $this->min = (int) $min;
        $this->max = (int) $max;
    }

    /**
     * Валидация числовых значений
     * @param mixed $value Валидируемое значение
     * @return bool
     */
    final public function check($value)
    {
        if (!is_numeric($value))
            return false;

        $value = (int) $value;

        return $this->min <= $value && $value <= $this->max;
    }
}
