<?php
/**
 * Progress bar for console applications
 *
 * @file      CliProgressBar.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk
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
	/** @var float Progress bar percent */
	protected $pb_percent;
	/** @var float Current progress bar percent  */
	protected $percent;
	/** @var float Progress bar initialization time  */
	protected $start_time;
	/** @var int Progress bar final value */
	protected $final_value;
	/** @var float Time when update calculation started */
	protected $curr_time;
	/** @var float Time when last update calculation finished */
	protected $last_update_time = 0.0;
	/** @var float Time between finishing last update and starting current update */
	protected $clean_process_time = 0.0;
	/** @var string Function for memory usage */
	protected $mem_usage_func = 'memory_get_usage';
	/** @var string Function for max memory usage */
	protected $mem_peak_func = 'memory_get_peak_usage';
	/** @var int Progress bar width */
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
	 * This method is public only for testing purposes. Logic with calculation
	 * must be moved into builder or class-calculator.
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
		list($position, $end) = $this->getPosition($done);

		return [
			$end,
			str_repeat('=', $position),
			$this->width - $position,
			$this->getStatusString($current) . $this->getMemString()
		];
	}

	/**
	 * Returns cursor position and last string-part for bar
	 *
	 * @param $done
	 *
	 * @return array
	 */
	protected function getPosition($done)
	{
		return ($done < 100)
			? [(int) floor($this->pb_percent * $done), "\033[K\r"]
			: [$this->width, "\033[K" . PHP_EOL];
	}
}
