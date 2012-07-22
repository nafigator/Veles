<?php
/**
 * Уведомление об ошибке
 * @file    ErrorEmail.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Сбт Июл 21 10:59:33 2012
 * @version
 */

namespace Veles\Email;

use \SplObserver;

/**
 * Класс ErrorEmail
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class ErrorEmail extends AbstractEmail implements SplObserver
{
    /**
     * Инициализация параметров
     */
    final public function init()
    {
        $this->to = 'poligon@tut.by';

        $this->headers =  'From: poligon@tut.by\n';
        $this->headers .= 'X-Mailer: PHP/' . phpversion() . '\n';
        $this->headers .= 'MIME-Version: 1.0\n';
        $this->headers .= 'Content-type: text/html; charset=' . $this->charset . '\n';
        $this->headers .= 'Content-Transfer-Encoding: ' . $this->encoding;

        $this->subject =  '=?' . $this->charset . '?B?' . base64_encode('Новый комментарий') . '?=';
    }
}
