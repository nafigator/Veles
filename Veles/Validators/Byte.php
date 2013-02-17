<?php
/**
 * Валидатор значений байтов
 * @file    Byte.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Фев 17 10:48:43 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Validators;

use Veles\Validators\iValidator;

/**
 * Класс Byte
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Byte implements iValidator
{

    /**
     * Проверка на валидность байтовых значенй
     * @param mixed $size Размер в байтах
     * @return bool
     */
    final public function check($size)
    {
        return is_numeric($size);
    }

    /**
     * Преобразование значений байтов в удобочитаемый формат
     * @param int $size Значение в байтах
     * @param int $precision Точность возвращаемых значений
     */
    final public static function format($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        $size = max($size, 0);
        $pow = floor(($size ? log($size) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $size /= (1 << (10 * $pow));

        return round($size, $precision) . ' ' . $units[$pow];
    }
}
