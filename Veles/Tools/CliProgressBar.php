<?php
/**
 * Консольный прогресс-баг
 * @file    CliProgressBar.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Фев 16 20:07:56 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tools;

use Veles\Validators\Byte;

/**
 * Класс CliProgressBar
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class CliProgressBar
{
    private $bp_percent;
    private $percent;
    private $start_time;
    private $final_value;

    /**
     * Конструктор
     * @param int $final Числовой эквивалент финального результата
     * @param int $width
     */
    final public function __construct($final, $width = 60)
    {
        stream_set_blocking(STDIN, false);

        $this->width       = $width;
        $this->bp_percent  = $width / 100;
        $this->percent     = $final / 100;
        $this->start_time  = microtime(true);
        $this->final_value = $final;
        $this->update(0);
    }

    /**
     * Обновление прогресс-бара
     * @param int $current Числовой эквивалент состояния процесса
     */
    final public function update($current)
    {
        $done = $current / $this->percent;

        if ($done < 100) {
            $position = floor($this->bp_percent * $done);
            $end = "\033[K\r";
        } else {
            $position = $this->width;
            $end = "\033[K" . PHP_EOL;
        }

        $bar = str_repeat('=', $position);
        $space_len = $this->width - $position;

        $status = $this->getStatusString($current) . self::getMemString();

        self::stdinCleanup();

        echo ($space_len > 0)
            ? "\033[?25l[$bar>\033[{$space_len}C]$status$end"
            : "[$bar>]$status$end\033[?25h";
    }

    /**
     * Формирование строки со статистическими данными
     * @param int $current Текущее значение числового эквевалента процесса
     * @return string
     */
    final public function getStatusString($current)
    {
        $current   = max($current, 1);
        $avg_speed = $current / (microtime(true) - $this->start_time);

        $estimated = ($this->final_value - $current) / $avg_speed;
        $estimated = number_format($estimated, 1);

        $avg_speed = round($avg_speed);

        return " $current u | $avg_speed u/s | Est: $estimated s";
    }

    /**
     * Формирование строки с данными по использованию памяти
     * @return string
     */
    final public static function getMemString()
    {
        $mem = Byte::format(memory_get_usage());
        $max_mem = Byte::format(memory_get_peak_usage());

        return " | Mem: $mem | Max: $max_mem";
    }

    /**
     * Очищаем пользовательский ввод
     */
    private static function stdinCleanup()
    {
        if (!fgets(STDIN)) {
            return;
        }

        echo "\033[K\033[1A";
    }
}
