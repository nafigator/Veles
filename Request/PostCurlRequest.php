<?php
/**
 * @file    PostCurlRequest.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-01-20 20:16
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Request;

/**
 * Class PostCurlRequest
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class PostCurlRequest extends CurlRequest
{
	/** @var array */
	protected $default_options = [
		CURLOPT_RETURNTRANSFER => true,		// output to string instead stdout
		CURLOPT_CONNECTTIMEOUT => 10,		// timeout on connect
		CURLOPT_TIMEOUT        => 10,		// timeout on request
		CURLOPT_POST           => true
	];

	/**
	 * Set request data
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function setData(array $data)
	{
		return $this->setOption(CURLOPT_POSTFIELDS, $data);
	}
}