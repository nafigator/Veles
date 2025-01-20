<?php
/**
 * Base class for PHP token manipulation
 *
 * @file      PhpTokenBase.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      Tue Aug 26 17:43:40
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tools;

use Veles\Validators\ValidatorInterface;

/**
 * Class PhpTokenBase
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class PhpTokenBase
{
	/** @var  int */
	protected $identifier = 0;
	/** @var  string */
	protected $name = 'UNKNOWN';
	/** @var  int */
	protected $line = 0;
	/** @var  string */
	protected $content = '';

	/**
	 * Token constructor
	 *
	 * @param string|array $token
	 * @param ValidatorInterface   $validator
	 *
	 * @throws \Exception
	 */
	public function __construct($token, ValidatorInterface $validator)
	{
		if (!$validator->check($token)) {
			throw new \Exception('Not valid token value');
		}

		if (is_string($token)) {
			$this->content = $token;

			return;
		}

		$this->identifier = $token[0];
		$this->content    = $token[1];
		$this->line       = $token[2];
	}

	/**
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param int $identifier
	 */
	public function setId($identifier)
	{
		$this->identifier = $identifier;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->identifier;
	}

	/**
	 * @param int $line
	 */
	public function setLine($line)
	{
		$this->line = $line;
	}

	/**
	 * @return int
	 */
	public function getLine()
	{
		return $this->line;
	}
}
