<?php
/**
 * Base class for error handlers
 *
 * @file      BaseErrorHandler.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-08-10 10:07
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
}
