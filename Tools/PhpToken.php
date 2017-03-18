<?php
/**
 * Class for PHP token manipulation
 *
 * @file      PhpToken.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-09-06 09:12
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
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
