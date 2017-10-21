<?php
/**
 * Progress bar for console applications
 *
 * @file      CliProgressBar.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      Сбт Фев 16 20:07:56 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tools;

use Veles\Validators\ByteValidator;

/**
 * Class CliProgressBar
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class CliProgressBar
{
	protected $pb_percent;
	protected $percent;
	protected $start_time;
	protected $final_value;
	protected $curr_time;
	protected $last_update_time = 0.0;
	protected $clean_process_time = 0.0;
	protected $mem_usage_func = 'memory_get_usage';
	protected $mem_peak_func = 'memory_get_peak_usage';
	protected $width;

	/**
	 * Constructor
	 *
	 * @param int $final Final result quantity
	 * @param int $width ProgressBar width
	 */
	public function __construct($final, $width = 60)
	{
		$this->final_value = max($final, 1);
		$this->width       = $width;
		$this->pb_percent  = $width / 100;
		$this->percent     = $this->final_value / 100;
		$this->start_time  = microtime(true);
		$this->last_update_time = $this->start_time;
	}

	/**
	 * Progress bar update
	 *
	 * @param int $current Current process quantity
	 */
	public function update($current)
	{
		$this->curr_time = microtime(true);
		$this->clean_process_time += $this->curr_time - $this->last_update_time;

		list($end, $bar, $space_len, $status) = $this->calcParams($current);

		echo ($space_len > 0)
			? "\033[?25l[$bar>\033[{$space_len}C]$status$end"
			: "[$bar>]$status$end\033[?25h";

		$this->last_update_time = microtime(true);
	}

	/**
	 * Get string with statistic
	 *
	 * @param int $current Current process quantity
	 *
	 * @return string
	 */
	public function getStatusString($current)
	{
		$current   = max($current, 1);
		$avg_speed = round($current / $this->clean_process_time);
		$estimated = number_format(
			($this->final_value - $current) *
			($this->curr_time - $this->start_time) /
			$current, 1
		);

		return " $current u | $avg_speed u/s | Est: $estimated s";
	}

	/**
	 * Get string with memory statistic
	 *
	 * @return string
	 */
	public function getMemString()
	{
		$mem = ByteValidator::format(call_user_func($this->mem_usage_func));
		$max_mem = ByteValidator::format(call_user_func($this->mem_peak_func));

		return " | Mem: $mem | Max: $max_mem";
	}

	/**
	 * Calculate bar-string params
	 *
	 * @param int $current Current process quantity
	 *
	 * @return array
	 */
	protected function calcParams($current)
	{
		$done = number_format($current / $this->percent, 2);

		if ($done < 100) {
			$position = floor($this->pb_percent * $done);
			$end = "\033[K\r";
		} else {
			$position = $this->width;
			$end = "\033[K" . PHP_EOL;
		}

		$bar = str_repeat('=', $position);
		$space_len = $this->width - $position;

		$status = $this->getStatusString($current) . $this->getMemString();

		return [$end, $bar, $space_len, $status];
	}
}
