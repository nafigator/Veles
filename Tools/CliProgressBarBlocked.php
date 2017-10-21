<?php
/**
 * Progress bar for console applications with blocked keyboard interaction
 *
 * @file      CliProgressBarBlocked.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
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
		if (fgets($this->stream)) {
			echo "\033[K\033[1A";
		}

		parent::update($current);
	}
}
