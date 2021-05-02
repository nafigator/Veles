<?php
/**
 * Trait for handling base adapter routines
 *
 * @file      CacheAdapterTrait.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-01-16 05:31
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Traits;

use Exception;
use Veles\Cache\Adapters\CacheAdapterAbstract;
use Veles\Cache\Adapters\CacheAdapterInterface;

trait CacheAdapterTrait
{
	/** @var CacheAdapterInterface */
	protected static $adapter;
	/** @var  string|CacheAdapterAbstract */
	protected static $adapter_name;

	/**
	 * Set cache adapter initialisation
	 *
	 * @param CacheAdapterInterface $adapter Adapter
	 */
	public static function setAdapter(CacheAdapterInterface $adapter)
	{
		self::$adapter = $adapter;
	}

	/**
	 * Get cache adapter instance
	 *
	 * @throws Exception
	 * @return CacheAdapterInterface
	 */
	public static function getAdapter()
	{
		if (null === self::$adapter) {
			throw new Exception('Adapter not set!');
		}

		return self::$adapter;
	}
}
