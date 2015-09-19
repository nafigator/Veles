<?php
/**
 * Class-loader for routes config in ini format
 *
 * @file      IniConfigLoader.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-05-24 12:08
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
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
		$this->buildTree($data);

		return $data;
	}

	/**
     * Build array parameters
     *
     * @param array &$config
     */
	private function buildTree(array &$config)
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
