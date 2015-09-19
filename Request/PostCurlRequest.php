<?php
/**
 * Class for fast making HTTP post requests
 *
 * @file      PostCurlRequest.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2015 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-01-20 20:16
 * @license   The BSD 3-Clause License
 *            <http://opensource.org/licenses/BSD-3-Clause>
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
	 * @param string|array $data
	 *
	 * @return bool
	 */
	public function setData($data)
	{
		return $this->setOption(CURLOPT_POSTFIELDS, $data);
	}
}
