<?php
/**
 * Base class for form elements
 * @file    AbstractElement.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 14 21:52:39 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

use stdClass;
use Exception;

/**
 * Class AbstractElement
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
abstract class AbstractElement extends stdClass implements iElement
{
	/**
	 * Element constructor
	 * @param array $params Form elements params array
	 */
	final public function __construct($params)
	{
		foreach ($params as $param => $value) {
			$this->$param = $value;
		}
	}

	/**
	 * Element validation
	 * @param mixed $value Value for validation
	 * @return bool
	 */
	final public function validate($value)
	{
		if (false ===  $this->validator) {
			return true;
		}

		if ($this->validator->check($value)) {
			$this->attributes['value'] = $value;
			return true;
		}

		return false;
	}

	/**
	 * Check is element required
	 */
	final public function required()
	{
		return $this->required;
	}

	/**
	 * Getting elements name
	 */
	final public function getName()
	{
		if (!isset($this->attributes['name'])) {
			throw new Exception('Element name not exist');
		}

		return $this->attributes['name'];
	}

	/**
	 * Rendering for each element
	 *
	 * Implements in descendant classes
	 */
	abstract public function render();

	/**
	 * Element attributes rendering
	 */
	final public function attributes()
	{
		$attributes = ' ';

		if (!isset($this->attributes)) {
			return $attributes;
		}

		foreach ($this->attributes as $name => $value) {
			$attributes .= " $name=\"$value\" ";
		}

		return $attributes;
	}
}
