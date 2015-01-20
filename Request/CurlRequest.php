<?php
/**
 * @file    CurlRequest.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-01-20 18:12
 * @copyright The BSD 3-Clause License
 */

namespace Request;

/**
 * Class CurlRequest
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class CurlRequest
{
	protected $curl;
	protected $default_options = [
		CURLOPT_RETURNTRANSFER => true,		// output to string instead stdout
		CURLOPT_CONNECTTIMEOUT => 10,		// timeout on connect
		CURLOPT_TIMEOUT        => 10,		// timeout on request
	];

	/**
	 * Creates cURL handler and sets options
	 *
	 * @param       $url
	 * @param array $options
	 */
	public function __construct($url, array $options = [])
	{
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_URL, curl_escape($this->curl, $url));
		curl_setopt_array($this->curl, $options + $this->default_options);
	}

	public function __destruct()
	{
		curl_close($this->curl);
	}

	/**
	 * Executes request and by default returns result as string
	 *
	 * @return mixed
	 */
	public function exec()
	{
		return curl_exec($this->curl);
	}
}
