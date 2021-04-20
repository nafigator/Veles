<?php
/**
 * Exception for non founded routes
 *
 * @file      NotFoundException.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-08-12 07:01
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
