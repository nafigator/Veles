<?php
/**
 * Interface for request validators
 *
 * @file      ValidatorInterface.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-17 13:05
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request\Validator;

/**
 * Interface ValidatorInterface
 *
 * @author   Yancharuk Alexander <alex at itvault at info>
 */
interface ValidatorInterface
{
	/**
	 * Add error
	 *
	 * @param array $error
	 */
	public function addError(array $error);

	/**
	 * Get error array
	 *
	 * @return array
	 */
	public function getErrors();

	/**
	 * Validate data
	 *
	 * @param mixed $data
	 * @param mixed $definitions
	 */
	public function check($data, $definitions);

	/**
	 * Check validation result
	 *
	 * @return bool
	 */
	public function isValid();
}
