<?php
/**
 * Error handler
 * @file    ErrBase.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Пнд Июл 16 22:08:47 2012
 * @version
 */

namespace Veles\ErrorHandler;

use Exception;
use SplObserver;
use SplSubject;
use Veles\DataBase\DbException;
use Veles\View\View;

/**
 * Class Error
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ErrBase implements SplSubject
{
	private $vars;
	private $output;
	private $observers = array();

	/**
	 * Handler for user errors
	 *
	 * @param $type
	 * @param $message
	 * @param $file
	 * @param $line
	 * @param $defined
	 */
	public function usrError($type, $message, $file, $line, $defined)
	{
		$this->vars['type']    = $this->getErrorType($type);
		$this->vars['time']    = strftime(
			'%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']
		);
		$this->vars['message'] = $message;
		/** @noinspection PhpUndefinedConstantInspection */
		$this->vars['file']    = str_replace(BASE_PATH, '', $file);
		$this->vars['line']    = $line;
		$this->vars['stack']   = $this->getStack(
			array_reverse(debug_backtrace())
		);
		$this->vars['defined'] = $defined;

		$this->process();
	}

	/**
	 * Fatal error handler
	 */
	public function fatal()
	{
		if (null === ($this->vars = error_get_last())) exit;

		$this->vars['type']    = $this->getErrorType($this->vars['type']);
		$this->vars['time']    = strftime(
			'%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']
		);
		/** @noinspection PhpUndefinedConstantInspection */
		$this->vars['file']    = str_replace(
			BASE_PATH, '', $this->vars['file']
		);
		$this->vars['stack']   = array();
		$this->vars['defined'] = array();

		$this->process();
	}

	/**
	 * Exception handler
	 * @param Exception $exception Исключение
	 */
	public function exception($exception)
	{
		$this->vars['type']    = $this->getErrorType($exception->getCode());
		$this->vars['time']    = strftime(
			'%Y-%m-%d %H:%M:%S', $_SERVER['REQUEST_TIME']
		);
		$this->vars['message'] = $exception->getMessage();
		/** @noinspection PhpUndefinedConstantInspection */
		$this->vars['file']    = str_replace(
			BASE_PATH, '', $exception->getFile()
		);
		$this->vars['line']    = $exception->getLine();
		$this->vars['stack']   = $this->getStack(
			array_reverse($exception->getTrace())
		);
		$this->vars['defined'] = ($exception instanceof DbException)
			? array(
				'connect_error' => $exception->getConnectError(),
				'sql_error'     => $exception->getSqlError(),
				'sql_query'     => $exception->getSqlQuery())
			: array();

		$this->process();
	}

	/**
	 * Processing according to environment
	 */
	public function process()
	{
		if ('development' === ENVIRONMENT) {
			View::set($this->vars);
			View::show('error/exception.phtml');
		} else {
			View::set($this->vars);
			$this->output = View::get('error/exception.phtml');

			//TODO: $this->attach(new ErrorSMS($this->vars));
			$this->attach(new ErrMail());
			$this->notify();

			//TODO: go to custom error page;
			exit;
		}
	}

	/**
	 * Get error type
	 * @param string $type
	 * @return string
	 */
	private function getErrorType($type)
	{
		$err_types = array(
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
		);

		return (isset($err_types[$type]))
			? $err_types[$type]
			: "UNKNOWN ERROR TYPE: $type";
	}

	/**
	 * Calls stack formatting
	 * @param array $stack Calls array
	 * @return array
	 */
	private function getStack($stack)
	{
		foreach ($stack as &$call) {
			$call['function'] = (isset($call['class']))
				? $call['class'] . $call['type'] . $call['function']
				: $call['function'];

			$call['file'] = (isset($call['file']))
				? $call['file'] . '<b>:</b>' . $call['line']
				: '';
		}

		return $stack;
	}

	/**
	 * Observers notification
	 */
	public function notify()
	{
		/** @var $observer SplObserver */
		foreach ($this->observers as $observer) {
			$observer->update($this);
		}
	}

	/**
	 * Add Observer
	 *
	 * @param SplObserver $observer
	 */
	public function attach(SplObserver $observer)
	{
		$this->observers[] = $observer;
	}

	/**
	 * Remove Observer
	 *
	 * @param SplObserver $observer
	 */
	public function detach(SplObserver $observer)
	{
		foreach ($this->observers as $key => $subscriber) {
			if ($subscriber == $observer) {
				unset($this->observers[$key]);
				return;
			}
		}
	}

	/**
	 * Get message for email-notification
	 * @return string
	 */
	public function getMessage()
	{
		return $this->output;
	}
}
