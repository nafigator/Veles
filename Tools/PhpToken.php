<?php
/**
 * Class for PHP token manipulation
 *
 * @file      PhpToken.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2015-09-06 09:12
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
 */

namespace Veles\Tools;

/**
 * Class PhpToken
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class PhpToken extends PhpTokenBase
{
	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		if ('UNKNOWN' === $this->name) {
			$this->setName(token_name($this->getId()));
		}

		return $this->name;
	}
}
