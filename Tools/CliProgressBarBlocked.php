<?php
/**
 * Progress bar for console applications with blocked keyboard interaction
 *
 * @file      CliProgressBarBlocked.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-12-05 19:01
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Tools;

/**
 * Class CliProgressBarBlocked
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class CliProgressBarBlocked extends CliProgressBar
{
	protected $stream = STDIN;

	public function __construct($final, $width = 60)
	{
		stream_set_blocking($this->stream, 0);

		parent::__construct($final, $width);
	}

	public function update($current)
	{
		$this->curr_time = microtime(true);
		$this->clean_process_time += $this->curr_time - $this->last_update_time;

		list ($end, $bar, $space_len, $status) = $this->calcParams($current);

		if (fgets($this->stream)) {
			echo "\033[K\033[1A";
		}

		echo ($space_len > 0)
			? "\033[?25l[$bar>\033[{$space_len}C]$status$end"
			: "[$bar>]$status$end\033[?25h";

		$this->full_cycle_time = microtime(true) - $this->last_update_time;
		$this->last_update_time = microtime(true);
	}
}
