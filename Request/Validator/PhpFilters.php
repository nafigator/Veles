<?php
/**
 * Class for processing PHP filters definitions
 *
 * @file      PhpFilters.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @date      2017-01-21 16:11
 */

namespace Veles\Request\Validator;

/**
 * Class   PhpFilters
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class PhpFilters implements ValidatorInterface
{
	/** @var  array */
	protected $errors = [];
	/** @var  mixed */
	protected $data;
	/** @var  array */
	protected $definitions = [];

	/**
	 * Add error
	 *
	 * @param array $error
	 */
	public function addError(array $error)
	{
		$this->errors[] = $error;
	}

	/**
	 * Get error array
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 * Validate data
	 *
	 * @param array $data
	 * @param array $definitions
	 */
	public function check($data, $definitions)
	{
		$this->definitions = $definitions;
		if (false !== ($this->data = filter_var_array($data, $definitions))) {
			$this->processResult();
		}
	}

	/**
	 * Check validation result
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return [] === $this->errors;
	}

	/**
	 * Get valid data
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Process result
	 */
	protected function processResult()
	{
		foreach ($this->data as $field => $value) {
			$this->checkField($field, $value);
		}
	}

	/**
	 * Add errors for for not valid or required fields
	 *
	 * @param $field
	 * @param $value
	 */
	protected function checkField($field, $value)
	{
		switch (true) {
			case $value === null:
				if (isset($this->definitions[$field]['required'])) {
					$this->addError($this->buildRequiredError($field));
				}
				break;
			case $value === false:
				$this->addError($this->buildNotValidError($field));
				break;
			default:
				break;
		}
	}

	/**
	 * Build "required" error
	 *
	 * @param $field
	 *
	 * @return array
	 */
	protected function buildRequiredError($field)
	{
		return [
			'field'   => $field,
			'message' => "$field is required"
		];
	}

	/**
	 * Build "not-valid" error
	 *
	 * @param $field
	 *
	 * @return array
	 */
	protected function buildNotValidError($field)
	{
		return [
			'field'   => $field,
			'message' => "$field is not a valid value"
		];
	}
}
