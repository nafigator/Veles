<?php
/**
 * Base class for curl requests
 *
 * @file      CurlAbstract.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk
 * @date      2015-01-20 23:10
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest;

use Veles\CurlRequest\AuthStrategies\AuthStrategyInterface;

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
	/** @var AuthStrategyInterface Authentication strategy */
	protected $auth;

	/**
	 * Creates cURL handler and sets options
	 *
	 * @param       $url
	 * @param array $options
	 */
	abstract public function __construct($url, array $options = []);

	/**
	 * Returns error code
	 *
	 * @return int
	 */
	public function getErrorCode()
	{
		return curl_errno($this->curl);
	}

	/**
	 * Returns error message
	 *
	 * @return string
	 */
	public function getError()
	{
		return curl_error($this->curl);
	}

	/**
	 * Returns info for given option or associative array of options values
	 *
	 * @param mixed $option
	 *
	 * @return mixed
	 */
	public function getInfo($option = null)
	{
		return null === $option
			? curl_getinfo($this->curl)
			: curl_getinfo($this->curl, $option);
	}

	/**
	 * Returns curl resource
	 *
	 * @return resource
	 */
	public function getResource()
	{
		return $this->curl;
	}
}
