<?php
/**
 * Adapter for JsonSchema library
 *
 * @file      JsonSchemaAdapter.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-17 14:54
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request\Validator\Adapters;

use JsonSchema\RefResolver;
use JsonSchema\Validator;
use Veles\Request\Validator\ValidatorInterface;
use Veles\Traits\Driver;

/**
 * Class   JsonSchemaAdapter
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class JsonSchemaAdapter implements ValidatorInterface
{
	use Driver;

	public function __construct()
	{
		$this->driver = new Validator;
	}

	/**
	 * Add error
	 *
	 * @param array $error
	 *
	 * @return mixed
	 */
	public function addError(array $error)
	{
		$field = $message = '';
		extract($error, EXTR_IF_EXISTS);

		$this->getDriver()->addError($field, $message);
	}

	/**
	 * Get error array
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->getDriver()->getErrors();
	}

	/**
	 * Validate data
	 *
	 * @param mixed $data
	 * @param mixed $definitions
	 */
	public function check($data, $definitions)
	{
		$resolver = new RefResolver();
		$resolver->resolve($definitions);

		$this->getDriver()->check($data, $definitions);
	}

	/**
	 * Check validation result
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return $this->getDriver()->isValid();
	}
}
