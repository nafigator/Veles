<?php
/**
 * @file    IniConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-05-24 12:08
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Routing;

/**
 * Class IniConfigLoader
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
		$data = parse_ini_file($this->getPath(), true);
		$this->buildPramsTree($data);

		return $data;
	}

	/**
     * Build array parameters
     *
     * @param array &$config
     */
	private function buildPramsTree(array &$config)
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
}
