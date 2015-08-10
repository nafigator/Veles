<?php
/**
 * @file      BaseErrorHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-10 10:07
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler;

use Veles\Helpers\Observable;

/**
 * Class BaseErrorHandler
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class BaseErrorHandler extends Observable
{
	/** @var array */
	protected $vars = [];

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
	 * Method stub. Must be implemented in child classes
	 */
	public function run() {}
}
