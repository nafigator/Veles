<?php

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
				self::$host, self::$port, $errno, $errstr, 0.01
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
	 * @param int $port
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
		$slabs  = [];
		$regex_items = '/^STAT items:(\d+):number (\d+)$/';
		$regex_keys  = '/ITEM ([^\s]+)/';

		foreach ($lines as $line) {
			if (1 !== preg_match($regex_items, $line, $match)) {
				continue;
			}

			$slabs[] = "$match[1] $match[2]";
		}
		unset($lines, $line, $match);

		foreach ($slabs as $slab) {
			$query = "stats cachedump $slab";
			$output = $this->query($query);

			if (preg_match_all($regex_keys, $output, $match)) {
				foreach ($match[1] as $key) {
					if (false !== strpos($key, $tpl)) {
						$this->command("delete $key");
					}
				}
			}
		}
		unset($output, $slabs, $slab, $match);

		return $this;
	}

	/**
	 * Run console command with output returning
	 *
	 * @param string $command Memcache console internal command
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
}
