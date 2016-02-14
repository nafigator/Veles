<?php
/**
 * Cache adapter and singleton functionality
 *
 * @file      CacheAdapterAbstract.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      8/22/13 16:20
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

use Veles\Traits\LazyCalls;

/**
 * Class CacheAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class CacheAdapterAbstract
{
	use LazyCalls;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();
}
