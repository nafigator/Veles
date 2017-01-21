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
	/** @var  array */
	protected $result = [];
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
	 * @param mixed $data
	 * @param mixed $definitions
	 */
	public function check($data, $definitions)
	{
		$this->definitions = $definitions;
		$this->result      = filter_var_array($data, $definitions);

		$this->processResult();
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
	 * Process result
	 */
	protected function processResult()
	{
		foreach ($this->result as $field => $value) {
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
				if (isset($this->definitions[$field]['options']['required'])) {
					$this->addError([
						'field'   => $field,
						'message' => "$field is required"
					]);
				}
				break;
			case $value === false:
				$this->addError([
					'field'   => $field,
					'message' => "$field is not a valid value"
				]);
				break;
			default: break;
		}
	}
}
