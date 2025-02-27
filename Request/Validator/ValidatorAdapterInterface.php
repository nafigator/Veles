<?php
/**
 * Interface for request validator adapters
 *
 * @file      ValidatorAdapterInterface.php
 *
 * PHP version 8.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-17 13:10
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request\Validator;

/**
 * Interface ValidatorAdapterInterface
 *
 * @author   Yancharuk Alexander <alex at itvault at info>
 */
interface ValidatorAdapterInterface
{
	/**
	 * Getting adapter
	 *
	 * @return ValidatorInterface
	 */
	public function getAdapter();

	/**
	 * Set validator
	 *
	 * @param ValidatorInterface $adapter
	 *
	 * @return $this
	 */
	public function setAdapter(ValidatorInterface $adapter);
}
