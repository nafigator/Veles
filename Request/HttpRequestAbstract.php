<?php
/**
 * Base class for http-request processing
 *
 * @file      HttpRequestAbstract.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-01-18 10:14
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Request;

use Veles\Request\Validator\ValidatorInterface;

/**
 * Class   HttpRequestAbstract
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
abstract class HttpRequestAbstract
{
	/** @var string  */
	protected $stream = 'php://input';
	protected $validator;
	/** @var array Valid data */
	protected $data;

	/**
	 * Save data after validation
	 *
	 * @param array $data
	 */
	protected function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Getting http-request body
	 *
	 * @return array
	 */
	abstract public function getBody();

	/**
	 * Check input according definitions
	 *
	 * @param mixed $definitions
	 */
	abstract public function check($definitions);

	/**
	 * Setting stream for request data reading
	 *
	 * @param string $stream
	 */
	public function setStream($stream)
	{
		$this->stream = $stream;
	}

	/**
	 * Getting validator
	 *
	 * @return ValidatorInterface
	 */
	public function getValidator()
	{
		return $this->validator;
	}

	/**
	 * Setting validator
	 *
	 * @param $validator
	 *
	 * @return $this
	 */
	public function setValidator(ValidatorInterface $validator)
	{
		$this->validator = $validator;

		return $this;
	}

	/**
	 * Getting valid data
	 *
	 * @param $definitions
	 *
	 * @return array
	 */
	public function getData($definitions)
	{
		$this->check($definitions);

		return $this->data;
	}
}
