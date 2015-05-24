<?php
/**
 * Error email-notification
 * @file    ErrMail.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Сбт Июл 21 10:59:33 2012
 * @version
 */

namespace Veles\ErrorHandler;

use Exception;
use SplObserver;
use Veles\Email\AbstractEmail;

/**
 * Class ErrEmail
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class ErrMail extends AbstractEmail implements SplObserver
{
	/**
	 * Params initialization
	 */
	public function init()
	{
		if (null === $this->receiver) {
			$msg = 'Error notification email not set!';
			throw new Exception($msg);
		}

		$this->from		= isset($_SERVER['SERVER_NAME'])
			? $_SERVER['SERVER_NAME']
			: $_SERVER['SERVER_ADDR'];
		$this->headers  = "From: www@itvault.info\n";
		$this->headers .= 'X-Mailer: PHP/' . phpversion() . "\n";
		$this->headers .= "MIME-Version: 1.0\n";
		$this->headers .= "Content-type: text/html; charset=$this->charset \n";
		$this->headers .= "Content-Transfer-Encoding: $this->encoding";
		$subject 		= base64_encode('itvault.info Error');
		$this->subject  = "=?$this->charset?B?$subject?=";
	}
}
