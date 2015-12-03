<?php
/**
 * Console colors
 *
 * @file      CliColor.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      Птн Фев 15 21:54:29 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tools;

use Exception;

/**
 * Class CliColor
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class CliColor
{
	private $color;

	private $style;

	private $string;

	private static $colors = [
		'black'  => '0',
		'red'    => '1',
		'green'  => '2',
		'yellow' => '3',
		'blue'   => '4',
		'purple' => '5',
		'cyan'   => '6',
		'white'  => '7'
	];

	private static $styles = [
		'0' => 'default',
		'1' => 'bold',
		'2' => 'dark',
		'4' => 'underline',
		'7' => 'invert',
		'9' => 'strike'
	];

	/**
	 * Encapsulate string in color esc-sequences
	 *
	 * @param string $string Строка
	 *
	 * @return string
	 */
	public function __invoke($string = null)
	{
		if (null === $string) {
			if (null === $this->string) {
				return '';
			}

			$string =& $this->string;
		}

		return "\033[{$this->getStyle()};3{$this->getColor()}m$string\033[0m";
	}

	/**
	 * Constructor
	 *
	 * @param string $color Color
	 * @param array  $style Styles array
	 *
	 * @throws Exception
	 */
	public function __construct($color = 'green', array $style = ['default'])
	{
		$this->setColor($color);
		$this->setStyle($style);
	}

	/**
	 * Output object as string
	 *
	 * @return mixed
	 */
	public function __toString()
	{
		if (null === $this->string) {
			return '';
		}

		$style = $this->getStyle();
		$color = $this->getColor();

		return "\033[$style;3{$color}m$this->string\033[0m";
	}

	/**
	 * Add string
	 *
	 * @param string $string String that should be colorized
	 *
	 * @throws Exception
	 * @return CliColor
	 */
	public function setString($string = null)
	{
		if (null === $string) {
			throw new Exception('Not valid string!');
		}

		$this->string = (string) $string;

		return $this;
	}

	/**
	 * Set style
	 *
	 * @param array $style Style
	 *
	 * @throws Exception
	 * @return CliColor
	 */
	public function setStyle(array $style = [])
	{
		$styles = array_flip(self::$styles);

		foreach ($style as $value) {
			if (!isset($styles[$value])) {
				throw new Exception("Not valid style: '$value'!");
			}
		}

		$this->style = $style;

		return $this;
	}

	/**
	 * Set color
	 *
	 * @param string $color Цвет
	 *
	 * @throws Exception
	 * @return CliColor
	 */
	public function setColor($color = null)
	{
		if (null === $color || !is_string($color)) {
			throw new Exception('Not valid color!');
		}

		if (!isset(self::$colors[$color])) {
			throw new Exception("Not valid color: '$color'!");
		}

		$this->color = $color;

		return $this;
	}

	/**
	 * Get style
	 *
	 * @return string
	 */
	private function getStyle()
	{
		$styles = array_keys(array_intersect(self::$styles, $this->style));

		return implode(';', $styles);
	}

	/**
	 * Get color
	 *
	 * @return string
	 */
	private function getColor()
	{
		return self::$colors[$this->color];
	}
}
