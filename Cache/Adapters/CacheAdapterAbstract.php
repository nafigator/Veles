<?php
/**
 * Cache adapter and singleton functionality
 *
 * @file      CacheAdapterAbstract.php
 *
 * PHP version 7.0+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk
 * @date      8/22/13 16:20
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

use Traits\DriverInterface;
use Traits\LazyCallsInterface;
use Traits\SingletonInstanceInterface;
use Veles\Traits\LazyCalls;

/**
 * Class CacheAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class CacheAdapterAbstract implements
	LazyCallsInterface,
	DriverInterface,
	SingletonInstanceInterface
{
	use LazyCalls;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();
}
