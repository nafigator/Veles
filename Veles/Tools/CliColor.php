<?php
/**
 * Цвета для консольного вывода
 * @file    CliColor.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Фев 15 21:54:29 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tools;

use \Exception;


/**
 * Класс CliColor
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class CliColor
{
    private $color;

    private $style;

    private $colors = array(
        'black'  => '0',
        'red'    => '1',
        'green'  => '2',
        'yellow' => '3',
        'blue'   => '4',
        'purple' => '5',
        'cyan'   => '6',
        'white'  => '7'
    );

    private $styles = array(
        '0' => 'default',
        '1' => 'bold',
        '2' => 'dark',
        '4' => 'underline',
        '7' => 'invert',
        '9' => 'strike'
    );

    /**
     * При вызове оборачивает строку esc-последовательностями цвета
     * @param string $string Строка
     */
    final public function __invoke($string = '')
    {
        if (empty($string)) {
            return '';
        }

        $styles = array_keys(array_intersect($this->styles, $this->style));
        $style  = implode(';', $styles);

        $color = $this->colors[$this->color];
        return "\033[$style;3{$color}m$string\033[0m";
    }

    /**
     * Конструктор
     * @param string $color Цвет
     */
    final public function __construct(
        $color = 'green', $style = array('default')
    ) {
        if (!is_array($style)) {
            throw new Exception('Style parameter must be an array!');
        }
        $this->color = $color;
        $this->style = $style;
    }
}
