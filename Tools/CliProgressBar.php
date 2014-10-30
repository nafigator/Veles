<?php
/**
 * Progress bar for console applications
 * @file    CliProgressBar.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Сбт Фев 16 20:07:56 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tools;

use Veles\Validators\Byte;

/**
 * Class CliProgressBar
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class CliProgressBar
{
	private $bp_percent;
	private $percent;
	private $start_time;
	private $final_value;
	private $block = false;
	private $curr_time;
	private $last_update_time = 0;
	private $cycle_time;
	private $clean_process_time = 0;


	/**
	 * Constructor
	 *
	 * @param int $final Числовой эквивалент финального результата
	 * @param int $width Ширина прогрессбара
	 * @param bool $block Флаг блокирования пользовательского ввода
	 */
	public function __construct($final, $width = 60, $block = false)
	{
		if ($block) {
			$this->block = true;
			stream_set_blocking(STDIN, false);
		}

		$this->final_value = max($final, 1);
		$this->width       = $width;
		$this->bp_percent  = $width / 100;
		$this->percent     = $this->final_value / 100;
		$this->start_time  = microtime(true);
		$this->last_update_time = $this->start_time;

		$this->update(0);
	}

	/**
	 * Progress bar update
	 *
	 * @param int $current Числовой эквивалент состояния процесса
	 */
	public function update($current)
	{
		$this->curr_time = microtime(true);
		$this->cycle_time = $this->curr_time - $this->last_update_time;
		$this->clean_process_time += $this->cycle_time;
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

		if ($this->block) {
			self::stdinCleanup();
		}

		echo ($space_len > 0)
			? "\033[?25l[$bar>\033[{$space_len}C]$status$end"
			: "[$bar>]$status$end\033[?25h";

		$this->last_update_time = microtime(true);
	}

	/**
	 * Get string with statistic
	 *
	 * @param int $current Текущее значение числового эквевалента процесса
	 * @return string
	 */
	public function getStatusString($current)
	{
		$current   = max($current, 1);
		$avg_speed = $current / $this->clean_process_time;

		$estimated = ($this->final_value - $current)
			/ ($current / (microtime(true) - $this->start_time));
		$estimated = number_format($estimated, 1);

		$avg_speed = round($avg_speed);

		return " $current u | $avg_speed u/s | Est: $estimated s";
	}

	/**
	 * Get string with memory statistic
	 *
	 * @return string
	 */
	public static function getMemString()
	{
		$mem = Byte::format(memory_get_usage());
		$max_mem = Byte::format(memory_get_peak_usage());

		return " | Mem: $mem | Max: $max_mem";
	}

	/**
	 * User input cleanup
	 */
	private static function stdinCleanup()
	{
		if (!fgets(STDIN)) {
			return;
		}

		echo "\033[K\033[1A";
	}
}
