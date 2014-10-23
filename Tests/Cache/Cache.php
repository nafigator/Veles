<?php
namespace Veles\Tests\Cache;

use Veles\Cache\Adapters\ApcAdapter;

/**
 * Class Cache
 *
 * Need for class Cache testing. In standard class static properties can't
 * available, so here added some methods for access them.
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Cache extends \Veles\Cache\Cache
{
	public static function unsetAdapter()
	{
		self::$adapter_name = null;
		self::$adapter 		= null;
	}

	public static function resetAdapter()
	{
		self::$adapter = ApcAdapter::instance();
	}
}
