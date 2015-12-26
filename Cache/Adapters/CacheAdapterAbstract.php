<?php
/**
 * Cache adapter and singleton functionality
 *
 * @file      CacheAdapterAbstract.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      8/22/13 16:20
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

use Traits\LazyCalls;

/**
 * Class CacheAdapterAbstract
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class CacheAdapterAbstract
{
	/** @var  mixed */
	protected $driver;

	use LazyCalls;

	/**
	 * Driver initialization
	 */
	abstract protected function __construct();

	/**
	 * Get adapter driver
	 *
	 * @return mixed
	 */
	public function getDriver()
	{
		return $this->driver;
	}

	/**
	 * Set adapter driver
	 *
	 * @param mixed $driver
	 */
	public function setDriver($driver)
	{
		$this->driver = $driver;
	}
}
