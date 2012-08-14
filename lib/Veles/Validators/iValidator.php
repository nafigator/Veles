<?php
/**
 * Интерфейс для валидаторов
 * @file    iValidator.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Втр Авг 14 23:58:56 2012
 * @version
 */

namespace Veles\Validators;

/**
 * Интерфейс iValidator
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
interface iValidator
{
    /**
     * Валидация
     * @param mixed $value Значения для проверки
     */
    public function check($value);
}
