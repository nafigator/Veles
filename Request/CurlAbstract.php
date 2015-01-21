<?php
/**
 * @file    CurlAbstract.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-01-20 23:10
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Request;

use Veles\Request\AuthStrategies\iAuthStrategy;

/**
 * Class CurlAbstract
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
abstract class CurlAbstract
{
	/** @var resource */
	protected $curl;
	/** @var array */
	protected $default_options = [
		CURLOPT_RETURNTRANSFER => true,		// output to string instead stdout
		CURLOPT_CONNECTTIMEOUT => 10,		// timeout on connect
		CURLOPT_TIMEOUT        => 10,		// timeout on request
	];
	/** @var array Current options set */
	protected $options = [];
	/** @var iAuthStrategy Authentication strategy */
	protected $auth;

	/**
	 * Creates cURL handler and sets options
	 *
	 * @param       $url
	 * @param array $options
	 */
	abstract public function __construct($url, array $options = []);

	public function getErrorCode()
	{
		return curl_errno($this->curl);
	}

	public function getError()
	{
		return curl_error($this->curl);
	}

	public function getInfo($option = null)
	{
		return null === $option
			? curl_getinfo($this->curl)
			: curl_getinfo($this->curl, $option);
	}
}
