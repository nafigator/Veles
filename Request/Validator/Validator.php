<?php
/**
 * Request validator
 *
 * @file      Validator.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-17 14:28
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request\Validator;

/**
 * Class   Validator
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class Validator implements ValidatorInterface, ValidatorAdapterInterface
{
	/** @var  ValidatorInterface */
	protected $adapter;

	/**
	 * Add error
	 *
	 * @param array $error
	 */
	public function addError(array $error)
	{
		$this->getAdapter()->addError($error);
	}

	/**
	 * Get error array
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->getAdapter()->getErrors();
	}

	/**
	 * Validate data
	 *
	 * @param mixed $data
	 * @param mixed $definitions
	 */
	public function check($data, $definitions)
	{
		$this->getAdapter()->check($data, $definitions);
	}

	/**
	 * Check validation result
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return $this->getAdapter()->isValid();
	}

	/**
	 * Getting adapter
	 *
	 * @return ValidatorInterface
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}

	/**
	 * Set validator
	 *
	 * @param ValidatorInterface $adapter
	 *
	 * @return $this
	 */
	public function setAdapter(ValidatorInterface $adapter)
	{
		$this->adapter = $adapter;

		return $this;
	}

	/**
	 * Get valid data
	 */
	public function getData()
	{
		return $this->getAdapter()->getData();
	}
}
