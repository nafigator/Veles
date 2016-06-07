<?php
/**
 * Memcache handler for searching by key substring
 *
 * @file      MemcachedAdapter.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Птн Ноя 01 17:52:46 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

use Exception;

/**
 * Class for key cleanup by prefix
 *
 * In memcache and memcached drivers not implemented key deletion by
 * template, this is the reason why this class have implementation of
 * key deletion through socket connection.
 * Can be used with Memcache only.
 */
class MemcacheRaw
{
	protected static $host;
	protected static $port;

	/**
	 * @var resource
	 */
	protected $connection;
	protected $regex = '/^(?:END|DELETED|NOT_FOUND|OK|ERROR|STORED|NOT_STORED|EXISTS|TOUCHED)\s+$/';

	/**
	 * Constructor. Open connection with Memcache server.
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		try {
			$this->connection = fsockopen(
				self::$host, self::$port, $errno, $errstr
			);
		} catch (Exception $e) {
			throw new Exception('Can not connect to Memcache. Host: '
				. self::$host . ' Port: ' . self::$port
			);
		}
	}

	/**
	 * Save connection params
	 *
	 * @param string $host
	 * @param int    $port
	 */
	public static function setConnectionParams($host, $port)
	{
		self::$host = $host;
		self::$port = $port;
	}

	/**
	 * Close memcache connection
	 *
	 * @return bool
	 */
	public function disconnect()
	{
		$this->command('quit');
		return fclose($this->connection);
	}

	/**
	 * Run memcache console command
	 *
	 * @param string $command Internal console memcache command
	 *
	 * @return MemcacheRaw
	 */
	public function command($command)
	{
		fwrite($this->connection, $command . PHP_EOL);
		fgets($this->connection);
	}

	/**
	 * Method for deletion keys by template
	 *
	 * ATTENTION: if key contains spaces, for example 'THIS IS KEY::ID:50d98ld',
	 * then in cache it will be saved as 'THIS_IS_KEY::ID:50d98ld'. So, template
	 * for that key deletion must be look like - 'THIS_IS_KEY'.
	 * Deletion can be made by substring, containing in keys. For example
	 * '_KEY::ID'.
	 *
	 * @param string $tpl Substring containing in needed keys
	 * @return MemcacheRaw
	 */
	public function delByTemplate($tpl)
	{
		$output = $this->query('stats items');
		$lines  = explode("\r\n", trim($output));

		$slabs = $this->getSlabs($lines);
		unset($lines);

		foreach ($slabs as $slab) {
			$query = "stats cachedump $slab";
			$output = $this->query($query);

			if (preg_match_all('/ITEM ([^\s]+)/', $output, $match)) {
				$this->delete($match[1], $tpl);
			}
		}
		unset($output, $slabs, $slab, $match);

		return $this;
	}

	/**
	 * Run console command with output returning
	 *
	 * @param string $command Memcache console internal command
	 *
	 * @return string
	 */
	public function query($command)
	{
		fwrite($this->connection, $command . PHP_EOL);

		$output = '';
		while (false !== ($str = fgets($this->connection))) {
			if (1 === preg_match($this->regex, $str)) {
				break;
			}

			$output .= $str;
		}

		return $output;
	}

	/**
	 * Get slabs array
	 *
	 * @param $lines
	 *
	 * @return array
	 */
	protected function getSlabs($lines)
	{
		$regex_items = '/^STAT items:(\d+):number (\d+)$/';
		$slabs = [];

		foreach ($lines as $line) {
			if (1 === preg_match($regex_items, $line, $match)) {
				$slabs[] = "$match[1] $match[2]";
			}
		}

		return $slabs;
	}

	/**
	 * Send delete matched keys from cache
	 *
	 * @param $match
	 * @param $tpl
	 */
	protected function delete($match, $tpl)
	{
		foreach ($match as $key) {
			if (false === strpos($key, $tpl))
				continue;

			$this->command("delete $key");
		}
	}
}
