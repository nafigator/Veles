<?php
/**
 * Class-loader for routes config in ini format
 *
 * @file      IniConfigLoader.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-05-24 12:08
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

/**
 * Class IniConfigLoader
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class IniConfigLoader extends AbstractConfigLoader
{
	/**
	 * Load routes data from file
	 *
	 * return array
	 */
	public function load()
	{
		$result = [];
		$data = parse_ini_file($this->getPath(), true);

		foreach ($data as $name => $section) {
			$this->buildTree($section);

			$result[$name] = $section;
		}

		return $result;
	}

	/**
	 * Build array parameters
	 *
	 * @param array &$config
	 */
	protected function buildTree(array &$config)
	{
		foreach ($config as $name => $value) {
			$params = explode('.', $name);

			if (1 === count($params)) {
				continue;
			}

			$this->processLine($config, $params, $value);

			unset($config[$name]);
		}
	}

	/**
	 * Processing config line
	 *
	 * @param array  $config
	 * @param array  $params
	 * @param string $value
	 */
	protected function processLine(array &$config, array $params, $value)
	{
		$ptr =& $config;
		$last = end($params);

		foreach ($params as $param) {
			if ($param === $last) {
				$ptr[$param] = $value;
				continue;
			}

			$ptr =& $ptr[$param];
		}
	}
}
