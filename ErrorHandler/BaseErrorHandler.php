<?php
/**
 * Base class for error handlers
 *
 * @file      BaseErrorHandler.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2015-08-10 10:07
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\ErrorHandler;

use Veles\Traits\Observable;

/**
 * Class BaseErrorHandler
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class BaseErrorHandler implements \SplSubject
{
	/** @var array */
	protected $vars = [];
	/** @var  string */
	protected $time;

	use Observable;

	/**
	 * Get error variables
	 *
	 * @return array
	 */
	public function getVars()
	{
		return $this->vars;
	}

	/**
	 * @return string
	 */
	public function getTime()
	{
		if (null === $this->time) {
			$this->time = date('Y-m-d H:i:s', time());
		}

		return $this->time;
	}

	/**
	 * @param string $time
	 *
	 * @return $this
	 */
	public function setTime($time)
	{
		$this->time = $time;

		return $this;
	}
}
