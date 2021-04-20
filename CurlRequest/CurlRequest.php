<?php
/**
 * Curl request class
 *
 * @file      CurlRequest.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk
 * @date      2015-01-20 18:12
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest;

use Veles\CurlRequest\AuthStrategies\AuthStrategyInterface;

/**
 * Class CurlRequest
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class CurlRequest extends CurlAbstract
{
	/**
	 * Creates cURL handler and sets options
	 *
	 * @param       $url
	 * @param array $options
	 */
	public function __construct($url, array $options = [])
	{
		$this->curl = curl_init();
		$options   += $this->default_options;

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
	public function setHeaders(array $headers)
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
	public function getHeaders()
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

		curl_setopt_array($this->curl, $options);

		return $this;
	}

	/**
	 * Set request authentication strategy
	 *
	 * @param AuthStrategyInterface $auth Authentication strategy
	 *
	 * @return $this
	 */
	public function setAuth(AuthStrategyInterface $auth)
	{
		$auth->apply($this);
		$this->auth = $auth;

		return $this;
	}
}
