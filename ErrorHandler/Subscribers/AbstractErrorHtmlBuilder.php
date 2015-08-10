<?php
/**
 * @file    AbstractErrorHtmlBuilder.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2015-06-06 20:19
 * @copyright The BSD 3-Clause License
 */

namespace Veles\ErrorHandler\Subscribers;

use Veles\ErrorHandler\BaseErrorHandler;

/**
 * Interface AbstractErrorHtmlBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
abstract class AbstractErrorHtmlBuilder
{
	/** @var  BaseErrorHandler */
	protected $handler;
	/** @var  string */
	protected $template;

	/**
	 * @param BaseErrorHandler $handler
	 */
	public function setHandler(BaseErrorHandler $handler)
	{
		$this->handler = $handler;
	}

	/**
	 * @return string
	 */
	abstract public function getHtml();

	/**
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * @param string $template
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
	}

	/**
	 * Get error type
	 * @param string $type
	 * @return string
	 */
	protected function getErrorType($type)
	{
		$err_types = [
			E_ERROR             => 'FATAL ERROR',               // 1
			E_WARNING           => 'WARNING',                   // 2
			E_PARSE             => 'PARSE ERROR',               // 4
			E_NOTICE            => 'NOTICE',                    // 8
			E_CORE_ERROR        => 'CORE ERROR',                // 16
			E_CORE_WARNING      => 'CORE WARNING',              // 32
			E_CORE_ERROR        => 'COMPILE ERROR',             // 64
			E_CORE_WARNING      => 'COMPILE WARNING',           // 128
			E_USER_ERROR        => 'USER ERROR',                // 256
			E_USER_WARNING      => 'USER WARNING',              // 512
			E_USER_NOTICE       => 'USER NOTICE',               // 1024
			E_STRICT            => 'STRICT NOTICE',             // 2048
			E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',         // 4096
			E_DEPRECATED        => 'DEPRECATED WARNING',        // 8192
			E_USER_DEPRECATED   => 'USER DEPRECATED WARNING',   // 16384
			0                   => 'EXCEPTION'
		];

		return (isset($err_types[$type]))
			? $err_types[$type]
			: "UNKNOWN ERROR TYPE: $type";
	}

	/**
	 * Calls backtrace formatting
	 *
	 * @param array $backtrace Calls array
	 * @return array
	 */
	protected function getBacktrace(array $backtrace)
	{
		foreach ($backtrace as &$call) {
			$call['function'] = (isset($call['class']))
				? $call['class'] . $call['type'] . $call['function']
				: $call['function'];

			$call['file'] = (isset($call['file']))
				? $call['file'] . '<b>:</b>' . $call['line']
				: '';
		}

		return $backtrace;
	}
}
