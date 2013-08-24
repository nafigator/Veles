<?php
/**
 * Class-parser project configuration
 * @file    Config.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Fri Jun 08 17:28:22 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles;

use Exception;
use Veles\Cache\Cache;

/**
 * Class Config
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Config
{
	private static $data = null;

	/**
	 * Config file parser
	 *
	 * @throws Exception
	 */
	private static function read()
	{
		self::checkDefaults();

		if (Cache::has(CONFIG_FILE)) {
			self::$data = Cache::get(CONFIG_FILE);
			return;
		}

		$tmp_config = parse_ini_file(CONFIG_FILE, true);

		self::initInheritance($tmp_config);

		if (!isset($tmp_config[ENVIRONMENT])) {
			throw new Exception('Не найдена секция окружения в конфиг-файле!');
		}

		self::$data = $tmp_config[ENVIRONMENT];

		unset($tmp_config);

		self::buildPramsTree(self::$data);
		Cache::set(CONFIG_FILE, self::$data);
	}

	/**
	 * Build array parameters
	 *
	 * @param array &$config
	 */
	private static function buildPramsTree(&$config)
	{
		foreach ($config as $name => $value) {
			$params = explode('.', $name);

			if (1 === count($params)) {
				continue;
			}

			$ptr =& $config;

			foreach ($params as $param) {
				if ($param === end($params)) {
					$ptr[$param] = $value;
				} else {
					$ptr =& $ptr[$param];
				}
			}

			unset($config[$name]);
		}
	}

	/**
	 * Config section inheritance
	 *
	 * @param array $config
	 */
	private static function initInheritance(&$config)
	{
		$namespaces = array_keys($config);
		foreach ($namespaces as $namespace) {
			$section = explode(':', $namespace);

			foreach ($section as &$value) {
				$value = trim($value);
			}

			// Process only environment section
			if (ENVIRONMENT !== $section[0]
				|| !isset($section[1])
				|| !isset($config[$section[1]])
			) {
				continue;
			}

			$config[ENVIRONMENT] = array_merge(
				$config[$section[1]], $config[$namespace]
			);
		}
	}

	/**
	 * Check environment and path defaults
	 */
	private static function checkDefaults()
	{
		defined('ENVIRONMENT') || define('ENVIRONMENT', 'production');

		defined('CONFIG_FILE')
			|| define('CONFIG_PATH', realpath('../../project/settings.ini'));
	}

	/**
	 * Get config file parameters
	 *
	 * @param string $param
	 * @return mixed
	 */
	final public static function getParams($param)
	{
		if (null === self::$data) {
			self::read();
		}

		$param_arr = explode('.', $param);

		$ptr =& self::$data;
		foreach ($param_arr as $param_element) {
			if (isset($ptr[$param_element])) {
				$ptr =& $ptr[$param_element];
			} else {
				return null;
			}
		}

		return $ptr;
	}
}
