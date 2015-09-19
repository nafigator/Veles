<?php
/**
 * Exception for non founded routes
 *
 * @file      NotFoundException.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-08-12 07:01
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Routing\Exceptions;

/**
 * Class NotFoundException
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class NotFoundException extends \DomainException
{
	public function __construct()
	{
		parent::__construct();
		header('HTTP/1.1 404 Not Found', true, 404);
	}
}
