<?php
/**
 * Class for PHP token
 *
 * @file    PhpToken.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    Tue Aug 26 17:43:40
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Tools;

use Veles\Validators\iValidator;

/**
 * Class PhpToken
 *
 * @package Veles\Tools
 */
class PhpToken
{
	/** @var  int */
	private $id = 0;
	/** @var  string */
	private $name = 'UNKNOWN';
	/** @var  int */
	private $line = 0;
	/** @var  string */
	private $content = '';

	/**
	 * Token constructor
	 *
	 * @param string|array $token
	 * @param iValidator   $validator
	 * @throws \Exception
	 */
	public function __construct($token, iValidator $validator)
	{
		if (!$validator->check($token)) {
			throw new \Exception('Not valid token value');
		}

		if (is_string($token)) {
			$this->content = $token;
			return;
		}

		$this->id      = $token[0];
		$this->content = $token[1];
		$this->line    = $token[2];
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
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
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
		return 'UNKNOWN' === $this->name
			? token_name($this->getId())
			: $this->name;
	}
}
