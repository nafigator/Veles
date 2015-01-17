<?php
/**
 * Base class for form elements
 * @file    AbstractElement.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Втр Авг 14 21:52:39 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Form\Elements;

use Exception;
use stdClass;
use Veles\Form\AbstractForm;

/**
 * Class AbstractElement
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
abstract class AbstractElement extends stdClass implements iElement
{
	/**
	 * Element constructor
	 *
	 * @param array $params Form elements params array
	 */
	public function __construct(array $params)
	{
		foreach ($params as $param => $value) {
			$this->$param = $value;
		}
	}

	/**
	 * Element validation
	 *
	 * @param AbstractForm $form Form object
	 *
	 * @return bool
	 */
	public function validate(AbstractForm $form)
	{
		if (null === ($value = $form->getData($this->getName()))) {
			return !$this->required();
		}

		if (false ===  $this->validator) {
			return true;
		}

		if ($this->validator->check($value)) {
			if (isset($this->attributes['name'])
				&& 'sid' !== $this->attributes['name']
			) {
				$this->attributes['value'] = $value;
			}
			return true;
		}

		return false;
	}

	/**
	 * Check for element requirement
	 *
	 * @return bool
	 */
	public function required()
	{
		return (bool) $this->required;
	}

	/**
	 * Getting elements name
	 */
	public function getName()
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
	public function attributes()
	{
		$attributes = '';

		if (!isset($this->attributes)) {
			return $attributes;
		}

		foreach ($this->attributes as $name => $value) {
			$attributes .= " $name=\"$value\" ";
		}

		return $attributes;
	}
}
