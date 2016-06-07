<?php
/**
 * Class for building errors in HTML format
 *
 * @file      ErrorBuilder.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2015-06-06 20:24
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\ErrorHandler\HtmlBuilders;

use Veles\ErrorHandler\BaseErrorHandler;
use Veles\View\View;

/**
 * Class ErrorBuilder
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class ErrorBuilder
{
	/** @var  BaseErrorHandler */
	protected $handler;
	/** @var  string */
	protected $template;
	/** @var array  */
	protected $types = [
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

	/**
	 * Get error type
	 * @param string $type
	 */
	protected function convertTypeToString(&$type)
	{
		$type = (isset($this->types[$type]))
			? $this->types[$type]
			: "UNKNOWN ERROR TYPE: $type";
	}

	/**
	 * Calls backtrace formatting
	 *
	 * @param array $backtrace Calls array
	 */
	protected function formatBacktrace(array &$backtrace)
	{
		foreach ($backtrace as &$call) {
			$call['function'] = (isset($call['class']))
				? $call['class'] . $call['type'] . $call['function']
				: $call['function'];

			$call['file'] = (isset($call['file']))
				? $call['file'] . '<b>:</b>' . $call['line']
				: '';
		}
	}

	/**
	 * @return BaseErrorHandler
	 */
	public function getHandler()
	{
		return $this->handler;
	}

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
	 * @return string
	 */
	public function getHtml()
	{
		$vars = $this->getHandler()->getVars();
		$this->formatBacktrace($vars['stack']);
		$this->convertTypeToString($vars['type']);
		View::set($vars);

		return View::get($this->getTemplate());
	}
}
