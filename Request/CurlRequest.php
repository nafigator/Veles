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

namespace Veles\Request;

use Veles\Request\AuthStrategies\iAuthStrategy;

/**
 * Class CurlRequest
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class CurlRequest
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
	public function __construct($url, array $options = [])
	{
		$this->curl = curl_init();

		$this->setOption(CURLOPT_URL, $url)
			->setArrayOptions($options);
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

	/**
	 * Sets additional header for request
	 *
	 * @param array $headers Array of additional headers
	 *
	 * @return $this
	 */
	public function setRequestHeaders(array $headers)
	{
		$this->options[CURLOPT_HTTPHEADER] = $headers;
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

		return $this;
	}

	/**
	 * Get headers set for prepared request
	 *
	 * @return array
	 */
	public function getRequestHeaders()
	{
		return isset($this->options[CURLOPT_HTTPHEADER])
			? $this->options[CURLOPT_HTTPHEADER]
			: [];
	}

	/**
	 * Set curl option
	 *
	 * @param $option
	 * @param $value
	 *
	 * @return $this
	 */
	public function setOption($option, $value)
	{
		$this->options[$option] = $value;
		curl_setopt($this->curl, $option, $value);

		return $this;
	}

	/**
	 * Sets additional options to curl-request
	 *
	 * @param array $options
	 *
	 * @return $this
	 */
	public function setArrayOptions(array $options)
	{
		foreach ($options as $option => $value) {
			$this->options[$option] = $value;
		}
		curl_setopt_array(
			$this->curl, $options + $this->default_options
		);

		return $this;
	}

	/**
	 * Set request authentication strategy
	 *
	 * @param iAuthStrategy $auth Authentication strategy
	 *
	 * @return $this
	 */
	public function setAuth(iAuthStrategy $auth)
	{
		$auth->apply($this);
		$this->auth = $auth;

		return $this;
	}
}
