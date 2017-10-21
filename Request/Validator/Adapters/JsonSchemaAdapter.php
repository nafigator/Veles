<?php
/**
 * Adapter for JsonSchema library
 *
 * @file      JsonSchemaAdapter.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-17 14:54
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request\Validator\Adapters;

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

	protected $resolver;

	public function __construct($driver, $resolver)
	{
		$this->driver   = $driver;
		$this->resolver = $resolver;
	}

	/**
	 * Add error
	 *
	 * @param array $error
	 */
	public function addError(array $error)
	{
		$field = $message = '';
		extract($error, EXTR_IF_EXISTS);

		$this->driver->addError($field, $message);
	}

	/**
	 * Get error array
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->driver->getErrors();
	}

	/**
	 * Validate data
	 *
	 * @param mixed $data
	 * @param mixed $definitions
	 */
	public function check($data, $definitions)
	{
		$this->resolver->resolve($definitions);

		$this->driver->check($data, $definitions);
	}

	/**
	 * Check validation result
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return $this->driver->isValid();
	}

	/**
	 * Method not used. Just a stub
	 *
	 * @codeCoverageIgnore
	 */
	public function getData()
	{
	}
}
