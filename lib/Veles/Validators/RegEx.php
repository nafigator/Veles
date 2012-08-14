<?php
/**
 * Валидатор по регулярному выражению
 * @file    RegEx.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 23:50:04 2012
 * @version
 */

namespace Veles\Validators;

/**
 * Класс RegEx
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class RegEx implements iValidator
{
    private $pattern;

    /**
     * Конструктор
     * @param string $pattern Шаблон для валидации
     */
    final public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Валидация
     * @param mixed $value Значения для проверки
     * @return bool
     */
    final public function check($value)
    {
        return (bool) preg_match($this->pattern, $value);
    }

    /**
     * Валидация (статический вариант)
     * @param string $pattern Шаблон для валидации
     * @param mixed $value Значения для проверки
     * @return bool
     */
    final public static function validate($pattern, $value)
    {
        return (bool) preg_match($pattern, $value);
    }
}
